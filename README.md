
#### Получение списка самых быстрых водителей
```
GET http://localhost/web/drivers/top?cityA=1&cityB=2
```

#### Получение списка водителей
```
GET http://localhost/web/drivers
```

#### Создание водителя
```
POST http://localhost/web/drivers
```
```
{
    "name": "Driver 1",
    "birthday": "05.31.1998",
    "buses": [
    	{"name": "Bus Model 1-1", "avg_speed": 220},
    	{"name": "Bus Model 1-2", "avg_speed": 220}
    ]
}
```

#### Oбновление водителя
```
PUT http://localhost/web/drivers/<id>
```
```
{
    "name": "Driver 1-1",
    "birthday": "12.31.2000",
    "buses": [
    	{"name": "Bus Model 2-1", "avg_speed": 220},
    	{"name": "Bus Model 2-2", "avg_speed": 220}
    ]
}
```