FROM php:8.2-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD [ "php", "./index.php" ]

# Using this docker file, run these commands:
# docker build -t queens-php .
# docker run -it --rm --name running-queens-php queens-php
