INSERT INTO users
(
   username
 , password
 , email
 , status
 , admin
 , rol_id
 , language_id
)
VALUES 
(
   'admin'
 , crypt('admin', gen_salt('bf', 10))
 , 'admin@venenciame.com'
 , 10
 , true
 , 1
 , 1
);

INSERT INTO users (
    username,
    password,
    email,
    status,
    admin,
    rol_id,
    language_id
  )
VALUES (
    'ana',
    crypt('ana', gen_salt('bf', 10)),
    'ana@venenciame.com',
    10,
    true,
    1,
    1
  );