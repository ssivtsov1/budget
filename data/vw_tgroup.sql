create view vw_tgroup AS
select 0 as ID,'Всі групи' as grup
union
select max(id) as ID,`спецификация`.`Розділ` AS `grup`
from `спецификация`
group by `спецификация`.`Розділ`
