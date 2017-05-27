<?php

include_once 'dbcontroller.php';

const base_url_person = 'http://is.stuba.sk/lide/clovek.pl'; // lang=sk;zalozka=5;id=4948

function curl_post($url, array $post = NULL, array $options = array())
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function parsePerson($xml){
    // Programmer's guide to fucking XPath on worthless perl page, pt. 2
    //
    //    echo $row->childNodes[0]->lastChild->textContent . '<br>'; // number
    //    foreach ($row->childNodes[1]->firstChild->childNodes as $node) echo $node->textContent . '<br>'; // all text
    //    echo $row->childNodes[2]->firstChild->lastChild->textContent . '<br>'; // category
    //    echo $row->childNodes[3]->firstChild->lastChild->textContent . '<br>'; // year
    //    echo $row->childNodes[4]->firstChild->lastChild->getAttribute('href'); // link

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($xml);
    $xPath = new DOMXPath($doc);

    $tableRows = $xPath->query('//*[@id="base-right"]/div/table[3]/tbody/tr');
    $responseA = [];
    foreach ($tableRows as $row) {
        $year = intval($row->childNodes[3]->firstChild->lastChild->textContent);
        $category = (string)$row->childNodes[2]->firstChild->lastChild->textContent;

        if ($year > 2011 &&
            strcmp( $category,'monografie, učebnice, skriptá, príručky, normy, patenty, výskumné správy, iné neperiodické publikácie') == 162) {
            $text = '';
            foreach ($row->childNodes[1]->firstChild->childNodes as $node) $text = $text . ' ' . $node->textContent;
            $responseA[] = [
                'name' => $text,
                'category' => $row->childNodes[2]->firstChild->lastChild->textContent,
                'year' => $row->childNodes[3]->firstChild->lastChild->textContent,
                'href' => 'http://is.stuba.sk/lide/' . $row->childNodes[4]->firstChild->lastChild->getAttribute('href')
            ];
        }
    }

    $responseB = [];
    foreach ($tableRows as $row) {
        $year = intval($row->childNodes[3]->firstChild->lastChild->textContent);
        $category = (string)$row->childNodes[2]->firstChild->lastChild->textContent;
        if ($year > 2011 &&
            strcmp( $category, "články v časopisoch") == 162) {
            $text = '';
            foreach ($row->childNodes[1]->firstChild->childNodes as $node) $text = $text . ' ' . $node->textContent;
            $responseB[] = [
                'name' => $text,
                'category' => $row->childNodes[2]->firstChild->lastChild->textContent,
                'year' => $row->childNodes[3]->firstChild->lastChild->textContent,
                'href' => 'http://is.stuba.sk/lide/' . $row->childNodes[4]->firstChild->lastChild->getAttribute('href')
            ];
        }
    }

    $responseC = [];
    foreach ($tableRows as $row) {
        $year = intval($row->childNodes[3]->firstChild->lastChild->textContent);
        $category = (string)$row->childNodes[2]->firstChild->lastChild->textContent;
        if ($year > 2011 &&
            strcmp( $category, "príspevky v zborníkoch, kapitoly v monografiách/učebniciach, abstrakty") == 162) {
            $text = '';
            foreach ($row->childNodes[1]->firstChild->childNodes as $node) $text = $text . ' ' . $node->textContent;
            $responseC[] = [
                'name' => $text,
                'category' => $row->childNodes[2]->firstChild->lastChild->textContent,
                'year' => $row->childNodes[3]->firstChild->lastChild->textContent,
                'href' => 'http://is.stuba.sk/lide/' . $row->childNodes[4]->firstChild->lastChild->getAttribute('href')
            ];
        }
    }

    usort($responseA, function($a, $b) {
        return $b['year'] <=> $a['year'];
    });

    usort($responseB, function($a, $b) {
        return $b['year'] <=> $a['year'];
    });

    usort($responseC, function($a, $b) {
        return $b['year'] <=> $a['year'];
    });

    return array_merge($responseA, $responseB, $responseC);
}

class Staff {

    private $db;

    function __construct()
    {
        $this->db = new DBController();
        $this->db->connectDB();
    }

    function getall() {
        $query = 'SELECT name, surname, title1, title2, room, phone, department, staffRole, function FROM staff;';
        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

    function getdetail($name, $surname) {
        $query = "SELECT name, surname, title1, title2, photo, staffRole, department, phone, room, ldapLogin
                  FROM staff
                  WHERE name='{$name}'
                  AND surname='{$surname}';";

        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

    function getdepartment($abbr) {
        $query = "SELECT full_name
                  FROM departments
                  WHERE abbrev='{$abbr}';";
        $result = $this->db->executeSelectQuery($query);

        return $result;
    }

    function curlPublications($login) {
        $dn = 'ou=People, DC=stuba, DC=sk';
        $ldapconn = ldap_connect("ldap.stuba.sk");
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        ldap_bind($ldapconn);

        $uid = "uid=" . $login;
        // search for relevant info in LDAP dir
        $results = ldap_search($ldapconn, $dn, $uid, array("uisid"));
        $info = ldap_get_entries($ldapconn, $results);

        $uisid = $info[0]['uisid'][0];
        ldap_unbind($ldapconn);

        if ($uisid == NULL){
            return null;
        }

        $arr = array(
            'lang' => 'sk', // language
            'zalozka' => '5', // publications
            'id' => $uisid, // user
            'rok' => '1'); // all publications

        $webpage = curl_post(base_url_person, $arr);

        if ($webpage == NULL){
            return null;
        }

        $answer = parsePerson($webpage);
        return $answer;
    }
}