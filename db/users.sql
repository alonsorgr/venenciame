INSERT INTO users
(
   username
 , password
 , email
 , status_id
 , admin
 , rol_id
 , language_id
)
VALUES 
(
   'admin'
 , crypt('admin', gen_salt('bf', 10))
 , 'alonsorgr@venenciame.com'
 , 3
 , true
 , 1
 , 1
);

INSERT INTO users (
    username,
    password,
    email,
    status_id,
    admin,
    rol_id,
    language_id
  )
VALUES (
    'paula',
    crypt('paula', gen_salt('bf', 10)),
    'paula@venenciame.com',
    3,
    false,
    1,
    1
  );