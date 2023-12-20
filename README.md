RUN : git clone git@github.com:goentur/adminkit-pro.git

ATAU

RUN : git clone https://github.com/goentur/adminkit-pro.git

RUN : composer install

RUN : npm install

RUN : cp .env.example .env

RUN : php artisan key:generate

RUN : php artisan migrate --seed

RUN : npm run dev

LOGIN

email : dev@mail.com

password : a