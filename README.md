## Задание 1
Для удобства создал миграцию `m240605_123731_mysql_query_task1`

Запрос выборки находится в файле `MySQLQueryBooks`

## Задание 2
Для развертывания и тестирования в командной строке последовательно необходимо ввести:

```bash
docker compose up -d # запустить контейнера
```
```bash
docker exec -it yii-application-backend-1 bash # команда для входа внутрь контейнера
```
```bash
./yii migrate # выполнить миграции
```
Запрос для получения списка валютных пар (вместе с фиксированным токеном)
```bash
curl -X GET http://localhost:21080/api/v1/rates/list -H "Authorization: Bearer rZkfr8iX2hkcust9lV5x2owoKHs7a3ESuPkaq0ERZ8VOhnqlicC4fKaR2bANcHtb"
```
Запрос для получения списка желаемых валют. При фильтрации нескольких валют, необходимо указать через запятую соответсвующие символы валют.
```bash
curl -X GET http://localhost:21080/api/v1/rates/list?currency_filter= -H "Authorization: Bearer rZkfr8iX2hkcust9lV5x2owoKHs7a3ESuPkaq0ERZ8VOhnqlicC4fKaR2bANcHtb"
```
Запрос на обмен валют (вместе с фиксированным токеном).
```bash
curl -X POST http://localhost:21080/api/v1/rates/convert -d "currency_from=USD&currency_to=BTC&value=1" -H "Authorization: Bearer rZkfr8iX2hkcust9lV5x2owoKHs7a3ESuPkaq0ERZ8VOhnqlicC4fKaR2bANcHtb"
```

Yii Readme is at [README.md](YII-README.md).