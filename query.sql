1.Выборки пользователей, у которых количество постов больше, чем у пользователя их пригласившего.

SELECT * FROM users u WHERE u.posts_qty > (SELECT posts_qty FROM users WHERE id = u.invited_by_user_id)

2.Выборки пользователей, имеющих максимальное количество постов в своей группе.

SELECT * FROM users u JOIN (SELECT group_id, max(posts_qty) pmax FROM users GROUP BY group_id) u2 ON u.group_id = u2.group_id AND u.posts_qty = u2.pmax

3.Выборки групп, количество пользователей в которых превышает 10000.

SELECT * FROM `groups` g JOIN (SELECT group_id, COUNT(users.id) as ucnt FROM users GROUP BY users.group_id HAVING ucnt > 10000) mx ON g.id = mx.group_id

4.Выборки пользователей, у которых пригласивший их пользователь из другой группы.

SELECT * FROM users u WHERE u.group_id <> (SELECT group_id FROM users WHERE id = u.invited_by_user_id)

5.Выборки групп с максимальным количеством постов у пользователей.

SELECT group_id, MAX(posts_qty), g.name FROM `users` u JOIN `groups` g ON g.id = u.group_id GROUP BY group_id


6. Добавления трех полей

begin;
set local statement_timeout = '1s';
alter table tablename
    add column columnname int;
    add column columnname2 int;
    add column columnname3 int;
commit;

7. Изменения одного поля
CREATE TABLE tablename2 AS
    TABLE tablename;

ALTER TABLE tablename2
ALTER COLUMN columnname TYPE needtype;

ALTER TABLE tablename
    RENAME TO tablename3;

ALTER TABLE tablename2
    RENAME TO tablename;

за короткое время придумал только так, таким же методом можно и первый случай делать


8. Добавления двух индексов
CREATE INDEX CONCURRENTLY indexname ON tablename (columnname)
CREATE INDEX CONCURRENTLY indexname2 ON tablename (columnname2)
