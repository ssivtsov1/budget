1. Тип деятельности

update budget
set type_act='1'
where type_act = 'Ліцензійна діяльність'

update budget
set type_act='2'
where type_act = 'Запоріжжя'

2. Виды ТМЦ

update budget
set vid_tmc='1'
where vid_tmc = 'Основні ТМЦ'

update budget
set vid_tmc='2'
where vid_tmc = 'Паливо'

update budget
set vid_tmc='3'
where vid_tmc = 'Інші ТМЦ'

3. Стаття бюджету

update budget
set page='1'
where page = 'Інструмент'

update budget
set page='2'
where page = 'Інші матеріальні витрати'

update budget
set page='3'
where page = 'Автозапчастини'

update budget
set page='4'
where page = 'Автошини'

update budget
set page='5'
where page = 'Акумулятори автомобільні'

update budget
set page='6'
where page = 'Бумага'

update budget
set page='7'
where page = 'Друкована продукція'

update budget
set page='8'
where page = 'ЗІЗ'

update budget
set page='9'
where page = 'Канцтовари'

update budget
set page='10'
where page = "Комп'ютерна техніка і зв'язок"

update budget
set page='11'
where page = "Література"

update budget
set page='12'
where page = "Миючі"

update budget
set page='13'
where page = "Паливо"

update budget
set page='14'
where page = "Ремонт будівельний"

update budget
set page='15'
where page = "Ремонт електрообладнання"

update budget
set page='16'
where page = "Спецодяг"

update budget
set page='17'
where page = "Технічнне обслуговування"

Остальные колонки:

update budget a,spr_edizm b
set a.ed_izm=b.id
where a.ed_izm = b.ed_izm

update budget a,spr_typerepair b
set a.vid_repair=b.id
where a.vid_repair = b.vid_repair

update budget a,spr_service b
set a.service=b.id
where a.service = b.service

update budget a,spr_spec b
set a.name_spec=b.id
where a.name_spec = b.name_spec


Колонка name_obj

update budget
set name_obj = '3'
where name_obj = 'Будівля (адм.-побут.)'

update budget
set name_obj = '2'
where name_obj like 'АБК%'

update budget
set name_obj = '12'
where name_obj ='облік'

// Проставляем поле ссылку id_zakaz в таблице budget

update `budget` a,`заказ` b, `spr_service` c
set a.id_zakaz = b.id
where  a.service=c.id and trim(a.name_tmc) = trim(b.`Найменування ТМЦ`)
and c.service = b.`РЕМ`


SELECT service,name_tmc,count(*) as kol
FROM budget WHERE 1
group by service,name_tmc
having count(*)>1

update budget a,spr_page b
set a.page=b.id
where trim(a.page1)=trim(b.page)

insert into `спецификация` (`Розділ`,`Найменування ТМЦ`,`Одиниця Виміру`,`Ціна`,`ЛОТ`)


insert into `спецификация` (`Розділ`,`Найменування ТМЦ`,`Одиниця Виміру`,`Ціна`,`ЛОТ`)
select distinct name_spec1,name_tmc,ed_izm1,price,lot from budget where name_tmc not like '%Кліпса під гофру 16 мм%' and 
name_spec1 not like '%Будівельні матеріали та супутні%'
Інструмент для зачистки і обжиму к

SELECT service1,sum(year_p) as year_p FROM `budget` group by service1










