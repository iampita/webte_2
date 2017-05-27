<?php
switch ($_SESSION['lang']) {
    case 'en':
        echo '<nav name="footer" class="bmenuBackground">
            <ul class="bdropDownMenu">
                <li><a href="http://is.stuba.sk" class="footer links">AIS STU</a></li>
                <li><a href="http://aladin.elf.stuba.sk/rozvrh/" class="footer links">Timetable FEI</a></li>
                <li><a href="http://elearn.elf.stuba.sk/moodle/" class="footer links">Moodle FEI</a></li>
                <li><a href="http://www.sski.sk/webstranka/" class="footer links">SSKI</a></li>
                <li><a href="https://www.jedalen.stuba.sk/WebKredit/" class="footer links">Canteen STU</a></li>
                <li><a href="https://webmail.stuba.sk/" class="footer links">Webmail STU</a></li>
                <li><a href="https://kis.cvt.stuba.sk/i3/epcareports/epcarep.csp?ictx=stu&language=1" class="footer links">Publications records STU</a></li>
                <li><a href="http://okocasopis.sk/" class="footer links">OKO magazine</a></li>
                <li><a href="https://www.facebook.com/UAMTFEISTU" class="footer links">UAMT FEI STU on Facebooku</a></li>
                <li><a href="https://www.youtube.com/channel/UCo3WP2kC0AVpQMIiJR79TdA" class="footer links">UAMT FEI STU on YouTube</a></li>
        </nav>';
        break;
    case 'sk':
    default:
        echo '<nav name="footer" class="bmenuBackground">
            <ul class="bdropDownMenu">
                <li><a href="http://is.stuba.sk" class="footer links">AIS STU</a></li>
                <li><a href="http://aladin.elf.stuba.sk/rozvrh/" class="footer links">Rozvrh hodín FEI</a></li>
                <li><a href="http://elearn.elf.stuba.sk/moodle/" class="footer links">Moodle FEI</a></li>
                <li><a href="http://www.sski.sk/webstranka/" class="footer links">SSKI</a></li>
                <li><a href="https://www.jedalen.stuba.sk/WebKredit/" class="footer links">Jedáleň STU</a></li>
                <li><a href="https://webmail.stuba.sk/" class="footer links">Webmail STU</a></li>
                <li><a href="https://kis.cvt.stuba.sk/i3/epcareports/epcarep.csp?ictx=stu&language=1" class="footer links">Evidencia publikácií STU</a></li>
                <li><a href="http://okocasopis.sk/" class="footer links">Časopis OKO</a></li>
                <li><a href="https://www.facebook.com/UAMTFEISTU" class="footer links">UAMT FEI STU na Facebooku</a></li>
                <li><a href="https://www.youtube.com/channel/UCo3WP2kC0AVpQMIiJR79TdA" class="footer links">UAMT FEI STU na YouTube</a></li>
        </nav>';
        break;
}