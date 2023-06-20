## 3D drukas pakalpojumu sludinājumu publicēšanas sistēma ar iespēju veidot pasūtījumus

### Programmas apraksts

No lietotāja puses, kurš vēlas sniegt 3D drukas pakalpojumus:
Šī sistēma ļauj ātri izveidot pakalpojumus, izvēloties esošo printeri un pieejamos materiālus no populāriem ražotājiem. Kad lietotāji atstāj pasūtījumus, jūs varat tos apskatīt un iestatīt drukāšanas laiku, kas, pamatojoties uz iestatījumiem, tiks ņemts vērā pasūtījuma cenā.

No lietotāja puses, kurš vēlas pasūtīt pakalpojumu:
Ir iespējams augšupielādēt sistēmā savu modeli un atrast servisu, kas atbilst drukas parametriem. Pēc tam ir iespējams atstāt pasūtījumu, uzrakstot savu adresi turpmākai piegādei.

### Izmantotas tehnoloģijas

* Wampserver - viens no populārākajiem rīkiem tīmekļa serveru izveidei operātājsistēmai Windows. Šis rīks ir aprīkots ar PHP programmēšanas valodas atbalstu (versija 8.1.13), ar MySQL datu bāzes pārvaldības sistēmu (versija 8.0.31), ar Apache2 serveri (versija 2.4.54.2) un ar phpMyAdmin datu bāzes pārvaldības rīku (5.2.0). Citi WampServer rīki netika izmantoti.
* Laravel – PHP ietvars ļauj ātri izveidot tīmekļa lietojumprogrammas. Projekta izveides laikā tika izmantota jaunākā versija 10.3.3.
* Composer - rīks PHP projektu izveidei ar pakotnes un bibliotēkas pārvaldnieku. Tika izmantota jaunākā versija 2.4.3.
* JavaScript - skriptu programmēšanas valoda, ko izmanto visās pārlūkprogrammās.
Bootstrap 5 - CSS ietvars ar gataviem elementiem. Tika izmantota jaunākā versija 5.3.0.
* Python — šajā valodā tika uzrakstīts viens skripts, lai izveidotu 3D modeļu attēlus.

### Uzstādīšanas instrukcijas

1. Ir nepieciešams instalēt visu iepriekš minēto programmatūru. MySQL, PHP, Apache2 tiek automātiski instalēts, instalējot Wampserver. Svarīgi, ka Composer ir jāinstalē pēc PHP instalēšanas, lai izvēlētos pareizo ceļu PHP versijai 8.1 vai jaunākai.
2. Tālāk ir jāizvēlas pareizā PHP versija. Noklikšķiniet uz WampServer ikonas uzdevumu joslā kreisajā pusē, ir jāvirza kursoru virs “PHP”, pēc tam virs “Version” un pēc tam noklikšķiniet uz jebkuras versijas, kas sākas ar “8.1” vai “8.2”.
3. Jums ir jāatver konsole (Windows logotipa taustiņš + R, ierakstiet "cmd" un nospiediet Enter). Pēc tam rindu pa rindiņai ievadiet šādas 7 komandas:
    * cd C:\wamp64\www
    * git clone https://github.com/MaximPixel/Kvalifik-cijas-darbs
    * cd C:\wamp64\www\Kvalifik-cijas-darbs
    * composer install
    * copy .env.example .env
    * php artisan key:generate
    * php artisan migrate
4. Failā pa ceļu “D:\wamp64\bin\apache\apache2.4.54.2\conf\extra\httpd-vhosts” (“2.4.54.2” vietā var būt cita instalēta versija) atveriet failu jebkurā teksta redaktorā un jādara šādi:
    * ceļš “${INSTALL_DIR}/www” jāizstāj ar “${INSTALL_DIR}/www/Kvalifik-cijas-darbs/public”,
    * ceļš “${INSTALL_DIR}/www/” jāizstāj ar “${INSTALL_DIR}/www/Kvalifik-cijas-darbs/public/”.
5. Pēc tam ir jārestartē Apache. Noklikšķiniet uz WampServer ikonas uzdevumu joslā kreisajā pusē un pēc tam noklikšķiniet uz "Restart All Services".
6. Tālāk ir jāizveido jauna datu bāze un jāizveido saites failu sistēmā, izmantojot šīs 2 komandas:
    * php artisan migrate
    * php artisan storage:link
7. Visbeidzot, jums ir jāuzsāk process, kas apstrādās fona uzdevumus, izmantojot šo komandu:
    * php artisan queue:work