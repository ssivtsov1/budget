create view vw_tovar as 
select max(`заказ`.ID) as ID,`заказ`.`РЕМ` as rem,`спецификация`.`Розділ` as grupa,`спецификация`.`Ціна` as price,
`заказ`.`Найменування ТМЦ` as tovar, `спецификация`.`Одиниця Виміру` as edizm,
round(SUM(`заказ`.`01`+`заказ`.`02`+`заказ`.`03`+`заказ`.`04`+`заказ`.`05`+`заказ`.`06`+`заказ`.`07`+
`заказ`.`08`+`заказ`.`09`+`заказ`.`10`+`заказ`.`11`+`заказ`.`12`),2) as kol_zak,
round(SUM(`заказ`.`В01`+`заказ`.`В02`+`заказ`.`В03`+`заказ`.`В04`+`заказ`.`В05`+`заказ`.`В06`+ 
`заказ`.`В07`+`заказ`.`В08`+`заказ`.`В09`+`заказ`.`В10`+`заказ`.`В11`+`заказ`.`В12`),2) as kol_give,
round(SUM(`заказ`.`01`+`заказ`.`02`+`заказ`.`03`+`заказ`.`04`+`заказ`.`05`+`заказ`.`06`+`заказ`.`07`+
`заказ`.`08`+`заказ`.`09`+`заказ`.`10`+`заказ`.`11`+`заказ`.`12`)-SUM(`заказ`.`В01`+`заказ`.`В02`+`заказ`.`В03`+`заказ`.`В04`+`заказ`.`В05`+`заказ`.`В06`+ 
`заказ`.`В07`+`заказ`.`В08`+`заказ`.`В09`+`заказ`.`В10`+`заказ`.`В11`+`заказ`.`В12`),2) as kol_zakup,
round(SUM(r.rq_1+r.rq_2+r.rq_3+r.rq_4+r.rq_5+r.rq_6+r.rq_7+
r.rq_8+r.rq_9+r.rq_10+r.rq_11+r.rq_12),2) as ost_res,
round(SUM(r.Oq_1+r.Oq_2+r.Oq_3+r.Oq_4+r.Oq_5+r.Oq_6+r.Oq_7+
r.Oq_8+r.Oq_9+r.Oq_10+r.Oq_11+r.Oq_12),2) as isp_res,
round(SUM(r.rp_1+r.rp_2+r.rp_3+r.rp_4+r.rp_5+r.rp_6+r.rp_7+
r.rp_8+r.rp_9+r.rp_10+r.rp_11+r.rp_12),3) as ostp_res,
round(SUM(r.rn_1+r.rn_2+r.rn_3+r.rn_4+r.rn_5+r.rn_6+r.rn_7+
r.rn_8+r.rn_9+r.rn_10+r.rn_11+r.rn_12),3) as ostn_res,
round(SUM(r.rz_1+r.rz_2+r.rz_3+r.rz_4+r.rz_5+r.rz_6+r.rz_7+
r.rz_8+r.rz_9+r.rz_10+r.rz_11+r.rz_12),3) as ostz_res,
round(SUM(r.rx_1+r.rx_2+r.rx_3+r.rx_4+r.rx_5+r.rx_6+r.rx_7+
r.rx_8+r.rx_9+r.rx_10+r.rx_11+r.rx_12),3) as ostx_res
from `заказ` INNER JOIN `спецификация` ON `заказ`.`Найменування ТМЦ` = `спецификация`.`Найменування ТМЦ`
LEFT JOIN vw_ostres r ON `заказ`.ID = r.id_zakaz
GROUP BY `заказ`.`Найменування ТМЦ`,`заказ`.`РЕМ`

// Старый
create view vw_tovar as 
select max(`заказ`.ID) as ID,`заказ`.`РЕМ` as rem,`спецификация`.`Розділ` as grupa,`спецификация`.`Ціна` as price,
`заказ`.`Найменування ТМЦ` as tovar, `спецификация`.`Одиниця Виміру` as edizm,
round(SUM(`заказ`.`01`+`заказ`.`02`+`заказ`.`03`+`заказ`.`04`+`заказ`.`05`+`заказ`.`06`+`заказ`.`07`+
`заказ`.`08`+`заказ`.`09`+`заказ`.`10`+`заказ`.`11`+`заказ`.`12`),2) as kol_zak,
round(SUM(`заказ`.`В01`+`заказ`.`В02`+`заказ`.`В03`+`заказ`.`В04`+`заказ`.`В05`+`заказ`.`В06`+ 
`заказ`.`В07`+`заказ`.`В08`+`заказ`.`В09`+`заказ`.`В10`+`заказ`.`В11`+`заказ`.`В12`),2) as kol_give,
round(SUM(`заказ`.`01`+`заказ`.`02`+`заказ`.`03`+`заказ`.`04`+`заказ`.`05`+`заказ`.`06`+`заказ`.`07`+
`заказ`.`08`+`заказ`.`09`+`заказ`.`10`+`заказ`.`11`+`заказ`.`12`)-SUM(`заказ`.`В01`+`заказ`.`В02`+`заказ`.`В03`+`заказ`.`В04`+`заказ`.`В05`+`заказ`.`В06`+ 
`заказ`.`В07`+`заказ`.`В08`+`заказ`.`В09`+`заказ`.`В10`+`заказ`.`В11`+`заказ`.`В12`),2) as kol_zakup,
round(SUM(r.`01`+r.`02`+r.`03`+r.`04`+r.`05`+r.`06`+r.`07`+
r.`08`+r.`09`+r.`10`+r.`11`+r.`12`),2) as ost_res,
round(SUM(`заказ`.`В01`+`заказ`.`В02`+`заказ`.`В03`+`заказ`.`В04`+`заказ`.`В05`+`заказ`.`В06`+ 
`заказ`.`В07`+`заказ`.`В08`+`заказ`.`В09`+`заказ`.`В10`+`заказ`.`В11`+`заказ`.`В12`),2)-
round(SUM(r.`01`+r.`02`+r.`03`+r.`04`+r.`05`+r.`06`+r.`07`+
r.`08`+r.`09`+r.`10`+r.`11`+r.`12`),2) as isp_res
from `заказ` INNER JOIN `спецификация` ON `заказ`.`Найменування ТМЦ` = `спецификация`.`Найменування ТМЦ`
LEFT JOIN tmc_res r ON `заказ`.ID = r.ID and `заказ`.`РЕМ` = r.rem
GROUP BY `заказ`.`Найменування ТМЦ`,`заказ`.`РЕМ`


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tovar` AS select max(`заказ`.`ID`) AS `ID`,`заказ`.`РЕМ` AS `rem`,`спецификация`.`Розділ` AS `grupa`,`спецификация`.`Ціна` AS `price`,`заказ`.`Найменування ТМЦ` AS `tovar`,`спецификация`.`Одиниця Виміру` AS `edizm`,round(sum((((((((((((`заказ`.`01` + `заказ`.`02`) + `заказ`.`03`) + `заказ`.`04`) + `заказ`.`05`) + `заказ`.`06`) + `заказ`.`07`) + `заказ`.`08`) + `заказ`.`09`) + `заказ`.`10`) + `заказ`.`11`) + `заказ`.`12`)),2) AS `kol_zak`,round(sum((((((((((((`заказ`.`В01` + `заказ`.`В02`) + `заказ`.`В03`) + `заказ`.`В04`) + `заказ`.`В05`) + `заказ`.`В06`) + `заказ`.`В07`) + `заказ`.`В08`) + `заказ`.`В09`) + `заказ`.`В10`) + `заказ`.`В11`) + `заказ`.`В12`)),2) AS `kol_give`,round((sum((((((((((((`заказ`.`01` + `заказ`.`02`) + `заказ`.`03`) + `заказ`.`04`) + `заказ`.`05`) + `заказ`.`06`) + `заказ`.`07`) + `заказ`.`08`) + `заказ`.`09`) + `заказ`.`10`) + `заказ`.`11`) + `заказ`.`12`)) - sum((((((((((((`заказ`.`В01` + `заказ`.`В02`) + `заказ`.`В03`) + `заказ`.`В04`) + `заказ`.`В05`) + `заказ`.`В06`) + `заказ`.`В07`) + `заказ`.`В08`) + `заказ`.`В09`) + `заказ`.`В10`) + `заказ`.`В11`) + `заказ`.`В12`))),2) AS `kol_zakup`,round(sum((((((((((((`r`.`rq_1` + `r`.`rq_2`) + `r`.`rq_3`) + `r`.`rq_4`) + `r`.`rq_5`) + `r`.`rq_6`) + `r`.`rq_7`) + `r`.`rq_8`) + `r`.`rq_9`) + `r`.`rq_10`) + `r`.`rq_11`) + `r`.`rq_12`)),2) AS `ost_res`,round(sum((((((((((((`r`.`oq_1` + `r`.`oq_2`) + `r`.`oq_3`) + `r`.`oq_4`) + `r`.`oq_5`) + `r`.`oq_6`) + `r`.`oq_7`) + `r`.`oq_8`) + `r`.`oq_9`) + `r`.`oq_10`) + `r`.`oq_11`) + `r`.`oq_12`)),2) AS `isp_res`,round(sum((((((((((((`r`.`rp_1` + `r`.`rp_2`) + `r`.`rp_3`) + `r`.`rp_4`) + `r`.`rp_5`) + `r`.`rp_6`) + `r`.`rp_7`) + `r`.`rp_8`) + `r`.`rp_9`) + `r`.`rp_10`) + `r`.`rp_11`) + `r`.`rp_12`)),3) AS `ostp_res`,round(sum((((((((((((`r`.`rn_1` + `r`.`rn_2`) + `r`.`rn_3`) + `r`.`rn_4`) + `r`.`rn_5`) + `r`.`rn_6`) + `r`.`rn_7`) + `r`.`rn_8`) + `r`.`rn_9`) + `r`.`rn_10`) + `r`.`rn_11`) + `r`.`rn_12`)),3) AS `ostn_res`,round(sum((((((((((((`r`.`rz_1` + `r`.`rz_2`) + `r`.`rz_3`) + `r`.`rz_4`) + `r`.`rz_5`) + `r`.`rz_6`) + `r`.`rz_7`) + `r`.`rz_8`) + `r`.`rz_9`) + `r`.`rz_10`) + `r`.`rz_11`) + `r`.`rz_12`)),3) AS `ostz_res`,round(sum((((((((((((`r`.`rx_1` + `r`.`rx_2`) + `r`.`rx_3`) + `r`.`rx_4`) + `r`.`rx_5`) + `r`.`rx_6`) + `r`.`rx_7`) + `r`.`rx_8`) + `r`.`rx_9`) + `r`.`rx_10`) + `r`.`rx_11`) + `r`.`rx_12`)),3) AS `ostx_res` from ((`заказ` join `спецификация` on((`заказ`.`Найменування ТМЦ` = `спецификация`.`Найменування ТМЦ`))) left join `vw_ostres` `r` on((`заказ`.`ID` = `r`.`id_zakaz`))) group by `заказ`.`Найменування ТМЦ`,`заказ`.`РЕМ` 
