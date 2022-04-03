Instalation
1. Donwload This file
2. Change old folder surat 
3. place this project in C:\\xampp\\htdocs\\
4. open terminal/git bash in this folder project
    4.1 type..  "composer update"
    4.2 Copy file .env from old folder surat to new folder surat
5. Change "$dompdf->getOptions()->setChroot("C:\\www\\surat\\public");" to "$dompdf->getOptions()->setChroot("C:\\xampp\\htdocts\\surat\\public");"

Run
1. type.. "php spark serve" to run serve
2. open in browser localhost:8080

Login
Admin / Admin
