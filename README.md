## How to run

create .env file, paste content from .env.example to .env

1. composer install
2. yarn install
3. php artisan key:generate
4. php artisan migrate
5. php artisan db:seed
6. php artisan elasticsearch:ping   (check if elasticsearch working)
7. php artisan generate:bookindex   (generate index of all books in books table)

8. In one terminal run server as <br>
php artisan serve

1. In another terminal run command 
yarn dev


default admin login <br>
email: admin@admin.com  <br>
password: password  <br>


## API

http://localhost:8000/api/books

http://localhost:8000/api/books?q=&perPage=10&page=1&sortBy=asc


## Elasticsearch Installation in ubuntu

// elasticsearch version 8  (java is required for elasticsearch, assuming that it already installed)
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.6.1-linux-x86_64.tar.gz
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.6.1-linux-x86_64.tar.gz.sha512
shasum -a 512 -c elasticsearch-8.6.1-linux-x86_64.tar.gz.sha512 
tar -xzf elasticsearch-8.6.1-linux-x86_64.tar.gz
cd elasticsearch-8.6.1/ 
echo 'export ES_HOME="$HOME/elasticsearch-8.6.1/"' >> ~/.bashrc
echo 'export PATH="$ES_HOME/bin:$PATH"' >> ~/.bashrc
exec $SHELL

## Run Elasticsearch

`open terminal and run below command`

elasticsearch

`Open another terminal window and check if elasticsearch running by`

curl -X GET 'http://localhost:9200'

`check elasticsearch runing in browser `

localhost:9200



http://localhost:9200/<index_name>/_doc/<id>

http://localhost:9200/books/_doc/1


Delete index

curl -X DELETE 'http://localhost:9200/<name_of_index>'
e.g.
curl -X DELETE 'http://localhost:9200/books'



## References

https://www.elastic.co
https://www.elastic.co/guide/index.html
https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html