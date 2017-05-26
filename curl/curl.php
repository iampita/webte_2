<?php

//kurl $typ => pre BP je to '1', pre DP je to '2'
function getCurldata($typ){
    $ch = curl_init('http://is.stuba.sk/pracoviste/prehled_temat.pl');
// zostavenie dat pre POST dopyt
    $data = array(
        'filtr_typtemata2' => $typ,
        'pracoviste' => '642',
        'lang' => 'sk',
        'omezit_temata2' => 'Obmedziť'
    );
// nastavenie curl-u pre pouzitie POST dopytu
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// nastavenie curl-u pre ulozenie dat z odpovede do navratovej hodnoty z volania curl_exec
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

// vykonanie dopytu
    $result = curl_exec($ch);
    curl_close($ch);

// parsovanie odpovede pre ziskanie pozadovanych dat
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($result);
    $xPath = new DOMXPath($doc);
    $tableRows = $xPath->query('//html/body/div/div/div/form/table[last()]/tbody/tr');
    $annotationURL = 'http://is.stuba.sk' . $tableRows[0]->childNodes[7]->firstChild->firstChild->getAttribute('href');
    return $tableRows;
}
function volneTemy($typ){
    $tableRows = getCurldata($typ);
    echo '<table><thead><th>Názov práce</th><th>Meno školiteľa</th><th>ŠP</th></thead>';
    foreach($tableRows as $i)
        if($i->childNodes[9]->textContent == "--")
            echo '<tr><td>'.$i->childNodes[2]->textContent.'</td><td>'.$i->childNodes[3]->textContent.'</td><td>'. $i->childNodes[5]->textContent .'</td></tr>';
    echo '</table>';
}
?>
