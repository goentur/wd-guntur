RUN : git clone git@github.com:goentur/wd-guntur.git

ATAU

RUN : git clone https://github.com/goentur/wd-guntur.git

RUN : composer install

RUN : npm install

RUN : cp .env.example .env

RUN : php artisan key:generate

RUN : php artisan migrate --seed

RUN : npm run dev

LOGIN

ADMIN

email : a@mail.com

password : a

PENYEWA

email : penyewa@mail.com

password : penyewa@mail.com