CREATE view vw_budget as
SELECT a.*,b.type_act as name_act,c.typetmc as type_tmc,d.page as page_b,
e.vid_repair as type_repair,g.name_spec as spec,
h.ed_izm as edizm,i.name_obj as obj,j.service as name_service,
r.rq_1,r.rp_1,r.oq_1,r.up_1,
r.rq_2,r.rp_2,r.oq_2,r.up_2,
r.rq_3,r.rp_3,r.oq_3,r.up_3,
r.rq_4,r.rp_4,r.oq_4,r.up_4,
r.rq_5,r.rp_5,r.oq_5,r.up_5,
r.rq_6,r.rp_6,r.oq_6,r.up_6,
r.rq_7,r.rp_7,r.oq_7,r.up_7,
r.rq_8,r.rp_8,r.oq_8,r.up_8,
r.rq_9,r.rp_9,r.oq_9,r.up_9,
r.rq_10,r.rp_10,r.oq_10,r.up_10,
r.rq_11,r.rp_11,r.oq_11,r.up_11,
r.rq_12,r.rp_12,r.oq_12,r.up_12,
(r.rq_1-r.oq_1) as rn_1,
(r.rq_2-r.oq_2) as rn_2,
(r.rq_3-r.oq_3) as rn_3,
(r.rq_4-r.oq_4) as rn_4,
(r.rq_5-r.oq_5) as rn_5,
(r.rq_6-r.oq_6) as rn_6,
(r.rq_7-r.oq_7) as rn_7,
(r.rq_8-r.oq_8) as rn_8,
(r.rq_9-r.oq_9) as rn_9,
(r.rq_10-r.oq_10) as rn_10,
(r.rq_11-r.oq_11) as rn_11,
(r.rq_12-r.oq_12) as rn_12,
(a.q_1-r.rq_1) as rz_1,
(a.q_2-r.rq_2) as rz_2,
(a.q_3-r.rq_3) as rz_3,
(a.q_4-r.rq_4) as rz_4,
(a.q_5-r.rq_5) as rz_5,
(a.q_6-r.rq_6) as rz_6,
(a.q_7-r.rq_7) as rz_7,
(a.q_8-r.rq_8) as rz_8,
(a.q_9-r.rq_9) as rz_9,
(a.q_10-r.rq_10) as rz_10,
(a.q_11-r.rq_11) as rz_11,
(a.q_12-r.rq_12) as rz_12,
(a.p_1-r.rp_1) as rx_1,
(a.p_2-r.rp_2) as rx_2,
(a.p_3-r.rp_3) as rx_3,
(a.p_4-r.rp_4) as rx_4,
(a.p_5-r.rp_5) as rx_5,
(a.p_6-r.rp_6) as rx_6,
(a.p_7-r.rp_7) as rx_7,
(a.p_8-r.rp_8) as rx_8,
(a.p_9-r.rp_9) as rx_9,
(a.p_10-r.rp_10) as rx_10,
(a.p_11-r.rp_11) as rx_11,
(a.p_12-r.rp_12) as rx_12
FROM budget a
left join spr_typeact b on a.type_act=b.id
left join spr_typetmc c on a.vid_tmc=c.id
left join spr_page d on a.page=d.id
left join spr_typerepair e on a.vid_repair=e.id
left join spr_spec g on a.name_spec=g.id
left join spr_edizm h on a.ed_izm=h.id
left join spr_obj i on a.name_obj=i.id
left join spr_service j on a.service=j.id
inner join budget_res r on a.id=r.id_budget



-- Из SQL Серевера
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_budget` AS select `a`.`id` AS `id`,`a`.`id_zakaz` AS `id_zakaz`,`a`.`type_act` AS `type_act`,`a`.`vid_tmc` AS `vid_tmc`,`a`.`page` AS `page`,`a`.`service` AS `service`,`a`.`name_obj` AS `name_obj`,`a`.`dname_obj` AS `dname_obj`,`a`.`vid_repair` AS `vid_repair`,`a`.`name_spec` AS `name_spec`,`a`.`lot` AS `lot`,`a`.`name_tmc` AS `name_tmc`,`a`.`ed_izm` AS `ed_izm`,`a`.`price` AS `price`,`a`.`q_1` AS `q_1`,`a`.`p_1` AS `p_1`,`a`.`q_2` AS `q_2`,`a`.`p_2` AS `p_2`,`a`.`q_3` AS `q_3`,`a`.`p_3` AS `p_3`,`a`.`aq_1` AS `aq_1`,`a`.`ap_1` AS `ap_1`,`a`.`q_4` AS `q_4`,`a`.`p_4` AS `p_4`,`a`.`q_5` AS `q_5`,`a`.`p_5` AS `p_5`,`a`.`q_6` AS `q_6`,`a`.`p_6` AS `p_6`,`a`.`aq_2` AS `aq_2`,`a`.`ap_2` AS `ap_2`,`a`.`q_7` AS `q_7`,`a`.`p_7` AS `p_7`,`a`.`q_8` AS `q_8`,`a`.`p_8` AS `p_8`,`a`.`q_9` AS `q_9`,`a`.`p_9` AS `p_9`,`a`.`aq_3` AS `aq_3`,`a`.`ap_3` AS `ap_3`,`a`.`q_10` AS `q_10`,`a`.`p_10` AS `p_10`,`a`.`q_11` AS `q_11`,`a`.`p_11` AS `p_11`,`a`.`q_12` AS `q_12`,`a`.`p_12` AS `p_12`,`a`.`aq_4` AS `aq_4`,`a`.`ap_4` AS `ap_4`,`a`.`year_q` AS `year_q`,`a`.`year_p` AS `year_p`,`b`.`type_act` AS `name_act`,`c`.`typetmc` AS `type_tmc`,`d`.`page` AS `page_b`,`e`.`vid_repair` AS `type_repair`,`g`.`name_spec` AS `spec`,`h`.`ed_izm` AS `edizm`,`i`.`name_obj` AS `obj`,`j`.`service` AS `name_service`,`r`.`rq_1` AS `rq_1`,`r`.`rp_1` AS `rp_1`,`r`.`oq_1` AS `oq_1`,`r`.`rq_2` AS `rq_2`,`r`.`rp_2` AS `rp_2`,`r`.`oq_2` AS `oq_2`,`r`.`rq_3` AS `rq_3`,`r`.`rp_3` AS `rp_3`,`r`.`oq_3` AS `oq_3`,`r`.`rq_4` AS `rq_4`,`r`.`rp_4` AS `rp_4`,`r`.`oq_4` AS `oq_4`,`r`.`rq_5` AS `rq_5`,`r`.`rp_5` AS `rp_5`,`r`.`oq_5` AS `oq_5`,`r`.`rq_6` AS `rq_6`,`r`.`rp_6` AS `rp_6`,`r`.`oq_6` AS `oq_6`,`r`.`rq_7` AS `rq_7`,`r`.`rp_7` AS `rp_7`,`r`.`oq_7` AS `oq_7`,`r`.`rq_8` AS `rq_8`,`r`.`rp_8` AS `rp_8`,`r`.`oq_8` AS `oq_8`,`r`.`rq_9` AS `rq_9`,`r`.`rp_9` AS `rp_9`,`r`.`oq_9` AS `oq_9`,`r`.`rq_10` AS `rq_10`,`r`.`rp_10` AS `rp_10`,`r`.`oq_10` AS `oq_10`,`r`.`rq_11` AS `rq_11`,`r`.`rp_11` AS `rp_11`,`r`.`oq_11` AS `oq_11`,`r`.`rq_12` AS `rq_12`,`r`.`rp_12` AS `rp_12`,`r`.`oq_12` AS `oq_12`,(`r`.`rq_1` - `r`.`oq_1`) AS `rn_1`,(`r`.`rq_2` - `r`.`oq_2`) AS `rn_2`,(`r`.`rq_3` - `r`.`oq_3`) AS `rn_3`,(`r`.`rq_4` - `r`.`oq_4`) AS `rn_4`,(`r`.`rq_5` - `r`.`oq_5`) AS `rn_5`,(`r`.`rq_6` - `r`.`oq_6`) AS `rn_6`,(`r`.`rq_7` - `r`.`oq_7`) AS `rn_7`,(`r`.`rq_8` - `r`.`oq_8`) AS `rn_8`,(`r`.`rq_9` - `r`.`oq_9`) AS `rn_9`,(`r`.`rq_10` - `r`.`oq_10`) AS `rn_10`,(`r`.`rq_11` - `r`.`oq_11`) AS `rn_11`,(`r`.`rq_12` - `r`.`oq_12`) AS `rn_12`,(`a`.`q_1` - `r`.`rq_1`) AS `rz_1`,(`a`.`q_2` - `r`.`rq_2`) AS `rz_2`,(`a`.`q_3` - `r`.`rq_3`) AS `rz_3`,(`a`.`q_4` - `r`.`rq_4`) AS `rz_4`,(`a`.`q_5` - `r`.`rq_5`) AS `rz_5`,(`a`.`q_6` - `r`.`rq_6`) AS `rz_6`,(`a`.`q_7` - `r`.`rq_7`) AS `rz_7`,(`a`.`q_8` - `r`.`rq_8`) AS `rz_8`,(`a`.`q_9` - `r`.`rq_9`) AS `rz_9`,(`a`.`q_10` - `r`.`rq_10`) AS `rz_10`,(`a`.`q_11` - `r`.`rq_11`) AS `rz_11`,(`a`.`q_12` - `r`.`rq_12`) AS `rz_12`,(`a`.`p_1` - `r`.`rp_1`) AS `rx_1`,(`a`.`p_2` - `r`.`rp_2`) AS `rx_2`,(`a`.`p_3` - `r`.`rp_3`) AS `rx_3`,(`a`.`p_4` - `r`.`rp_4`) AS `rx_4`,(`a`.`p_5` - `r`.`rp_5`) AS `rx_5`,(`a`.`p_6` - `r`.`rp_6`) AS `rx_6`,(`a`.`p_7` - `r`.`rp_7`) AS `rx_7`,(`a`.`p_8` - `r`.`rp_8`) AS `rx_8`,(`a`.`p_9` - `r`.`rp_9`) AS `rx_9`,(`a`.`p_10` - `r`.`rp_10`) AS `rx_10`,(`a`.`p_11` - `r`.`rp_11`) AS `rx_11`,(`a`.`p_12` - `r`.`rp_12`) AS `rx_12` from (((((((((`budget` `a` left join `spr_typeact` `b` on((`a`.`type_act` = `b`.`id`))) left join `spr_typetmc` `c` on((`a`.`vid_tmc` = `c`.`id`))) left join `spr_page` `d` on((`a`.`page` = `d`.`id`))) left join `spr_typerepair` `e` on((`a`.`vid_repair` = `e`.`id`))) left join `spr_spec` `g` on((`a`.`name_spec` = `g`.`id`))) left join `spr_edizm` `h` on((`a`.`ed_izm` = `h`.`id`))) left join `spr_obj` `i` on((`a`.`name_obj` = `i`.`id`))) left join `spr_service` `j` on((`a`.`service` = `j`.`id`))) join `budget_res` `r` on((`a`.`id` = `r`.`id_budget`)))




