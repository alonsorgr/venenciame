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
 , 'alonsorgr@gmail.com'
 , 1
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
    'ana',
    crypt('ana', gen_salt('bf', 10)),
    'ana@venenciame.com',
    1,
    false,
    1,
    1
  );