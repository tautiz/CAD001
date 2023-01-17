SELECT Count(*)
from users
         JOIN states ON users.state = states.id
WHERE states.title = 'Active';

SELECT distinct state from users;

SELECT p.first_name,
       p.last_name,
       a.city,
       if(c.title is null, 'No County', if(c.title = 'n/a', c.iso, c.title)) as country
FROM persons p
         LEFT JOIN addresses a ON a.id = p.address_id
         LEFT JOIN countries c ON c.iso = a.country_iso;

# 4 Uždavinys
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
select count(*) as studentu_kiekis, g.title, g.id, s.title
from `person2gruop`
         left join `groups` g on person2gruop.groups_id = g.id
         left join `states` s on g.state = s.id
where s.title = 'Suspended'
GROUP BY g.title;
SET sql_mode = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

# Aiškinamės kaip veikia 4 uždavinys
SELECT g.id, g.title, count(g.title) as studentu_kiekis
FROM person2gruop pg
         JOIN (SELECT id, title, COUNT(*) as count
               FROM `groups`
               GROUP BY title) g
              ON pg.groups_id = g.id
GROUP BY g.title;

select count(id) kiek, groups_id
from person2gruop
WHERE groups_id = 22
group by groups_id;

select *
from `groups`
where title = 'CS_MySQL_V';

# 5 Uždavinys
select count(*) as studentu_kiekis, g.title
from `person2gruop`
         left join `groups` g on person2gruop.groups_id = g.id
where g.title LIKE '%D'
GROUP BY g.title;

select SUM(t.studentu_kiekis) Kiek
FROM (
         select count(*) as studentu_kiekis
         from `person2gruop`
                  left join `groups` g on person2gruop.groups_id = g.id
         where g.title LIKE '%V'
         GROUP BY g.title) t;

#6 Uždavinys
select p.*, g.title
from `person2gruop` pg
         left join `groups` g on pg.groups_id = g.id
         left join `persons` p on p.id = pg.person_id
where g.title = 'CS_MySQL_V';

# suskaiciuos kiek yra studentu kurie yra CS_MySQL_V
select COUNT(*), g.title
from `person2gruop` pg
         left join `groups` g on pg.groups_id = g.id
         left join `persons` p on p.id = pg.person_id
where g.title = 'CS_MySQL_V';

#7 Uždavinys:
# Surasti visus asmenis (‘persons’) kurie neturi vardo (first_name’) arba pavardės (‘last_name’) ir turi
# neaktyvų (‘Inactive’) vartotoją (‘users’) (Jei tokių duomenų nėra prieš atliekant užduotį reikia
# pakoreguoti persons lentos  duomenis ir pašalinti keleta vardu ir pavardziu)

select p.*, u.*
from `persons` p
         left join `users` u on p.id = u.person_id
         LEFT JOIN states s on u.state = s.id
where (p.first_name is null
    or p.last_name is null
    OR p.first_name = ''
    or p.last_name = ''
    OR p.first_name = '-unknown-'
    or p.last_name = '-unknown-')
  AND s.title = 'Inactive';
;

# 8 Uždavinys
# Suskaičiuoti kiek grupių naudojasi tais pačiais adresais. Atvaizduoti kiekio stulpelį ir pilna adresą
# kaip vieną stulpelį. (viso 2 stulpeliai)
SELECT count(*) as kiek, concat(a.city, ' ', a.street) as pilnas_adresas

FROM `groups` g
         JOIN addresses a ON a.id = g.address_id
group by g.address_id
HAVING kiek > 1;
