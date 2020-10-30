--
-- PostgreSQL database dump
--

-- Dumped from database version 12.4 (Ubuntu 12.4-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.4 (Ubuntu 12.4-1.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: articles; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.articles (
    id bigint NOT NULL,
    partner_id bigint NOT NULL,
    category_id bigint NOT NULL,
    denomination_id bigint NOT NULL,
    vat_id bigint NOT NULL,
    status_id bigint DEFAULT 2,
    title character varying(50) NOT NULL,
    description character varying(255) NOT NULL,
    price numeric NOT NULL,
    stock integer NOT NULL,
    degrees character varying(50) NOT NULL,
    capacity integer NOT NULL,
    variety character varying(50) NOT NULL,
    pairing character varying(50) NOT NULL,
    review text NOT NULL,
    image character varying(255) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.articles OWNER TO venenciame;

--
-- Name: articles_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.articles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.articles_id_seq OWNER TO venenciame;

--
-- Name: articles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.articles_id_seq OWNED BY public.articles.id;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.categories OWNER TO venenciame;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_id_seq OWNER TO venenciame;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: countries; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.countries (
    id bigint NOT NULL,
    code character varying(2) NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.countries OWNER TO venenciame;

--
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.countries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_id_seq OWNER TO venenciame;

--
-- Name: countries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.countries_id_seq OWNED BY public.countries.id;


--
-- Name: denominations; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.denominations (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.denominations OWNER TO venenciame;

--
-- Name: denominations_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.denominations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.denominations_id_seq OWNER TO venenciame;

--
-- Name: denominations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.denominations_id_seq OWNED BY public.denominations.id;


--
-- Name: favorites; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.favorites (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    article_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.favorites OWNER TO venenciame;

--
-- Name: favorites_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.favorites_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.favorites_id_seq OWNER TO venenciame;

--
-- Name: favorites_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.favorites_id_seq OWNED BY public.favorites.id;


--
-- Name: followers; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.followers (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    partner_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.followers OWNER TO venenciame;

--
-- Name: followers_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.followers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.followers_id_seq OWNER TO venenciame;

--
-- Name: followers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.followers_id_seq OWNED BY public.followers.id;


--
-- Name: languages; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.languages (
    id bigint NOT NULL,
    code character varying(2) NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.languages OWNER TO venenciame;

--
-- Name: languages_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.languages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_id_seq OWNER TO venenciame;

--
-- Name: languages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.languages_id_seq OWNED BY public.languages.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO venenciame;

--
-- Name: notifications; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.notifications (
    id integer NOT NULL,
    class character varying(64) NOT NULL,
    key character varying(32) NOT NULL,
    message character varying(255) NOT NULL,
    route character varying(255) NOT NULL,
    seen boolean DEFAULT false NOT NULL,
    read boolean DEFAULT false NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    created_at integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.notifications OWNER TO venenciame;

--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO venenciame;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: partners; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.partners (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(32) NOT NULL,
    description character varying(255),
    information text,
    image character varying(255),
    country_id bigint NOT NULL,
    state_id bigint NOT NULL,
    status_id bigint,
    city character varying(64) NOT NULL,
    zip_code character varying(64) NOT NULL,
    address character varying(64) NOT NULL,
    phone character varying(64) NOT NULL,
    url character varying(64),
    email character varying(64),
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.partners OWNER TO venenciame;

--
-- Name: partners_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.partners_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partners_id_seq OWNER TO venenciame;

--
-- Name: partners_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.partners_id_seq OWNED BY public.partners.id;


--
-- Name: reviews; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.reviews (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    article_id bigint NOT NULL,
    review text NOT NULL,
    score integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT ck_value_min_max CHECK (((score >= 0) AND (score <= 5)))
);


ALTER TABLE public.reviews OWNER TO venenciame;

--
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviews_id_seq OWNER TO venenciame;

--
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.roles OWNER TO venenciame;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO venenciame;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: states; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.states (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    country_id bigint,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.states OWNER TO venenciame;

--
-- Name: states_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.states_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.states_id_seq OWNER TO venenciame;

--
-- Name: states_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.states_id_seq OWNED BY public.states.id;


--
-- Name: statuses; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.statuses (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.statuses OWNER TO venenciame;

--
-- Name: statuses_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.statuses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.statuses_id_seq OWNER TO venenciame;

--
-- Name: statuses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.statuses_id_seq OWNED BY public.statuses.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    username character varying(32) NOT NULL,
    password character varying(64) NOT NULL,
    email character varying(64) NOT NULL,
    auth_key character varying(32) DEFAULT NULL::character varying,
    verf_key character varying(32) DEFAULT NULL::character varying,
    status_id bigint,
    admin boolean DEFAULT false,
    privacity boolean DEFAULT false,
    name character varying(32),
    surname character varying(32),
    birthdate date,
    image character varying(255),
    rol_id bigint,
    language_id bigint,
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO venenciame;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO venenciame;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: vats; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.vats (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    value integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.vats OWNER TO venenciame;

--
-- Name: vats_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.vats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vats_id_seq OWNER TO venenciame;

--
-- Name: vats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.vats_id_seq OWNED BY public.vats.id;


--
-- Name: articles id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles ALTER COLUMN id SET DEFAULT nextval('public.articles_id_seq'::regclass);


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: countries id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.countries ALTER COLUMN id SET DEFAULT nextval('public.countries_id_seq'::regclass);


--
-- Name: denominations id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations ALTER COLUMN id SET DEFAULT nextval('public.denominations_id_seq'::regclass);


--
-- Name: favorites id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites ALTER COLUMN id SET DEFAULT nextval('public.favorites_id_seq'::regclass);


--
-- Name: followers id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers ALTER COLUMN id SET DEFAULT nextval('public.followers_id_seq'::regclass);


--
-- Name: languages id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages ALTER COLUMN id SET DEFAULT nextval('public.languages_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: partners id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners ALTER COLUMN id SET DEFAULT nextval('public.partners_id_seq'::regclass);


--
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: states id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states ALTER COLUMN id SET DEFAULT nextval('public.states_id_seq'::regclass);


--
-- Name: statuses id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses ALTER COLUMN id SET DEFAULT nextval('public.statuses_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: vats id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats ALTER COLUMN id SET DEFAULT nextval('public.vats_id_seq'::regclass);


--
-- Data for Name: articles; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.articles (id, partner_id, category_id, denomination_id, vat_id, status_id, title, description, price, stock, degrees, capacity, variety, pairing, review, image, created_at) FROM stdin;
1	1	7	4	2	3	Gitana	Una manzanilla fresca para beber.	5.50	10000	15	75	100% Palomino fino	Tapas, pescados, mariscos, ahumados.	Color: pajizo. Aroma: equilibrado, fresco, salino, expresivo, punzante. Boca: sabroso, fino amargor, largo. 	Gitana.jpg	2020-10-26 21:52:22
2	2	2	2	2	3	 Valdespino Palo Cortado Cardenal VORS	Fino Inocente y del amontillado Tío Diego	195	10	20.5	75	100% Palomino fino	Ahumados, frutos secos, quesos curados.	The Cardenal may be showing its age a little, but the intensity is unfailing, overlaid with honeyed, buttery notes. The palate is vivid and very long. Memorable.	 Valdespino Palo Cortado Cardenal VORS.jpg	2020-10-26 22:00:38
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.categories (id, label, created_at) FROM stdin;
1	Tinto	2020-10-26 21:34:46
2	Blanco	2020-10-26 21:34:46
3	Espumoso	2020-10-26 21:34:46
4	Generoso	2020-10-26 21:34:46
5	Dulce	2020-10-26 21:34:46
6	Rosado	2020-10-26 21:34:46
7	Manzanilla	2020-10-26 21:34:46
8	Fino	2020-10-26 21:34:46
9	Vermouth	2020-10-26 21:34:46
10	Vino Azul	2020-10-26 21:34:46
\.


--
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.countries (id, code, label, created_at) FROM stdin;
1	ES	España	2020-10-26 21:34:45
2	GB	United Kingdom	2020-10-26 21:34:45
3	DE	Germany	2020-10-26 21:34:45
4	FR	France	2020-10-26 21:34:45
5	PT	Portugal	2020-10-26 21:34:45
\.


--
-- Data for Name: denominations; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.denominations (id, label, created_at) FROM stdin;
1	Condado de Huelva	2020-10-26 21:34:46
2	Jerez-Sherry-Xérès	2020-10-26 21:34:46
3	Málaga	2020-10-26 21:34:46
4	Manzanilla de Sanlúcar	2020-10-26 21:34:46
5	Montilla-Moriles	2020-10-26 21:34:46
6	Lebrija	2020-10-26 21:34:46
7	Sierras de Málaga	2020-10-26 21:34:46
8	Vino Naranja del Condado de Huelva	2020-10-26 21:34:46
\.


--
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.favorites (id, user_id, article_id, created_at) FROM stdin;
1	2	2	2020-10-26 22:00:43
2	2	1	2020-10-26 22:01:36
3	1	2	2020-10-26 22:02:37
4	1	1	2020-10-26 22:03:09
\.


--
-- Data for Name: followers; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.followers (id, user_id, partner_id, created_at) FROM stdin;
1	1	1	2020-10-26 21:39:55
2	1	2	2020-10-26 21:47:13
3	2	1	2020-10-26 21:48:01
4	2	2	2020-10-26 21:48:09
\.


--
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.languages (id, code, label, created_at) FROM stdin;
1	ES	Español	2020-10-26 21:34:45
2	EN	English	2020-10-26 21:34:45
3	GE	Deutsche	2020-10-26 21:34:45
4	FR	Français	2020-10-26 21:34:45
5	PT	Português	2020-10-26 21:34:45
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1602533790
m010101_100001_init_notifications	1602533796
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.notifications (id, class, key, message, route, seen, read, user_id, created_at) FROM stdin;
1	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534093
2	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534112
3	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534244
4	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534259
5	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534267
6	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534292
7	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534295
8	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534325
\.


--
-- Data for Name: partners; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.partners (id, user_id, name, description, information, image, country_id, state_id, status_id, city, zip_code, address, phone, url, email, updated_at, created_at) FROM stdin;
1	1	La Gitana	Bodegas HIDALGO LA GITANA	Bodegas HIDALGO LA GITANA fue fundada en 1792 y desde entonces la firma ha pasado de padres a hijos, siendo hoy una de las pocas empresas vinateras del marco, gestionada por la familia y dirigida por la octava generación en línea directa del fundador.	1.jpg	1	1	3	Sanlúcar de Barrameda	11540	Avenida del Ejercito Nº2	+34637669147	https://lagitana.es/	contacto@lagitana.es	\N	2020-10-26 21:39:23
2	2	José Estévez	Establecida en 1809 y dedicada a la crianza de Jerez y Brandies	Las Bodegas José Estévez S.A. son los sucesores de la firma José Leña Rendón y Compañía, establecida en 1809 y dedicada a la crianza de Jerez y Brandies.	2.jpg	1	13	3	Jeréz de la Frontera	11408	Carretera Nacional IV Km 640	+34636987458	grupoestevez.es	contacto@joseestevez.es	\N	2020-10-26 21:43:54
\.


--
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.reviews (id, user_id, article_id, review, score, created_at) FROM stdin;
1	1	1	Maravillosa Manzanilla.	5	2020-10-26 22:11:35
2	1	2	Muy bueno pero muy caro.	1	2020-10-26 22:12:11
3	2	1	Me encanta, pero me gustan otras Manzanillas más.	2	2020-10-26 22:13:47
4	2	2	Me encanta este vino, pero algo caro.	4	2020-10-26 22:15:01
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.roles (id, label, updated_at, created_at) FROM stdin;
1	Administrador	\N	2020-10-26 21:34:45
2	Cliente	\N	2020-10-26 21:34:45
3	Usuario	\N	2020-10-26 21:34:45
\.


--
-- Data for Name: states; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.states (id, label, country_id, created_at) FROM stdin;
1	A Coruna	1	2020-10-26 21:34:45
2	Alacant	1	2020-10-26 21:34:45
3	Alava	1	2020-10-26 21:34:45
4	Albacete	1	2020-10-26 21:34:45
5	Almeria	1	2020-10-26 21:34:45
6	Asturias	1	2020-10-26 21:34:45
7	Avila	1	2020-10-26 21:34:45
8	Badajoz	1	2020-10-26 21:34:45
9	Balears	1	2020-10-26 21:34:45
10	Barcelona	1	2020-10-26 21:34:45
11	Burgos	1	2020-10-26 21:34:45
12	Caceres	1	2020-10-26 21:34:45
13	Cadiz	1	2020-10-26 21:34:45
14	Cantabria	1	2020-10-26 21:34:45
15	Castello	1	2020-10-26 21:34:45
16	Ceuta	1	2020-10-26 21:34:45
17	Ciudad Real	1	2020-10-26 21:34:45
18	Cordoba	1	2020-10-26 21:34:45
19	Cuenca	1	2020-10-26 21:34:45
20	Girona	1	2020-10-26 21:34:45
21	Granada	1	2020-10-26 21:34:45
22	Guadalajara	1	2020-10-26 21:34:45
23	Guipuzcoa	1	2020-10-26 21:34:45
24	Huelva	1	2020-10-26 21:34:45
25	Huesca	1	2020-10-26 21:34:45
26	Jaen	1	2020-10-26 21:34:45
27	La Rioja	1	2020-10-26 21:34:45
28	Las Palmas	1	2020-10-26 21:34:45
29	Leon	1	2020-10-26 21:34:45
30	Lleida	1	2020-10-26 21:34:45
31	Lugo	1	2020-10-26 21:34:45
32	Madrid	1	2020-10-26 21:34:45
33	Malaga	1	2020-10-26 21:34:45
34	Melilla	1	2020-10-26 21:34:45
35	Murcia	1	2020-10-26 21:34:45
36	Navarra	1	2020-10-26 21:34:45
37	Ourense	1	2020-10-26 21:34:45
38	Pais Vasco	1	2020-10-26 21:34:45
39	Palencia	1	2020-10-26 21:34:45
40	Pontevedra	1	2020-10-26 21:34:45
41	Salamanca	1	2020-10-26 21:34:45
42	Segovia	1	2020-10-26 21:34:45
43	Sevilla	1	2020-10-26 21:34:45
44	Soria	1	2020-10-26 21:34:45
45	Tarragona	1	2020-10-26 21:34:45
46	Santa Cruz de Tenerife	1	2020-10-26 21:34:45
47	Teruel	1	2020-10-26 21:34:45
48	Toledo	1	2020-10-26 21:34:45
49	Valencia	1	2020-10-26 21:34:45
50	Valladolid	1	2020-10-26 21:34:45
51	Vizcaya	1	2020-10-26 21:34:45
52	Zamora	1	2020-10-26 21:34:45
53	Zaragoza	1	2020-10-26 21:34:45
54	Aberdeen	2	2020-10-26 21:34:45
55	Aberdeenshire	2	2020-10-26 21:34:45
56	Argyll	2	2020-10-26 21:34:45
57	Armagh	2	2020-10-26 21:34:45
58	Bedfordshire	2	2020-10-26 21:34:45
59	Belfast	2	2020-10-26 21:34:45
60	Berkshire	2	2020-10-26 21:34:45
61	Birmingham	2	2020-10-26 21:34:45
62	Brechin	2	2020-10-26 21:34:45
63	Bridgnorth	2	2020-10-26 21:34:45
64	Bristol	2	2020-10-26 21:34:45
65	Buckinghamshire	2	2020-10-26 21:34:45
66	Cambridge	2	2020-10-26 21:34:45
67	Cambridgeshire	2	2020-10-26 21:34:45
68	Channel Islands	2	2020-10-26 21:34:45
69	Cheshire	2	2020-10-26 21:34:45
70	Cleveland	2	2020-10-26 21:34:45
71	Co Fermanagh	2	2020-10-26 21:34:45
72	Conwy	2	2020-10-26 21:34:45
73	Cornwall	2	2020-10-26 21:34:45
74	Coventry	2	2020-10-26 21:34:45
75	Craven Arms	2	2020-10-26 21:34:45
76	Cumbria	2	2020-10-26 21:34:45
77	Denbighshire	2	2020-10-26 21:34:45
78	Derby	2	2020-10-26 21:34:45
79	Derbyshire	2	2020-10-26 21:34:45
80	Devon	2	2020-10-26 21:34:45
81	Dial Code Dungannon	2	2020-10-26 21:34:45
82	Didcot	2	2020-10-26 21:34:45
83	Dorset	2	2020-10-26 21:34:45
84	Dunbartonshire	2	2020-10-26 21:34:45
85	Durham	2	2020-10-26 21:34:45
86	East Dunbartonshire	2	2020-10-26 21:34:45
87	East Lothian	2	2020-10-26 21:34:45
88	East Midlands	2	2020-10-26 21:34:45
89	East Sussex	2	2020-10-26 21:34:45
90	East Yorkshire	2	2020-10-26 21:34:45
91	England	2	2020-10-26 21:34:45
92	Essex	2	2020-10-26 21:34:45
93	Fermanagh	2	2020-10-26 21:34:45
94	Fife	2	2020-10-26 21:34:45
95	Flintshire	2	2020-10-26 21:34:45
96	Fulham	2	2020-10-26 21:34:45
97	Gainsborough	2	2020-10-26 21:34:45
98	Glocestershire	2	2020-10-26 21:34:45
99	Gwent	2	2020-10-26 21:34:45
100	Hampshire	2	2020-10-26 21:34:45
101	Hants	2	2020-10-26 21:34:45
102	Herefordshire	2	2020-10-26 21:34:45
103	Hertfordshire	2	2020-10-26 21:34:45
104	Ireland	2	2020-10-26 21:34:45
105	Isle Of Man	2	2020-10-26 21:34:45
106	Isle of Wight	2	2020-10-26 21:34:45
107	Kenford	2	2020-10-26 21:34:45
108	Kent	2	2020-10-26 21:34:45
109	Kilmarnock	2	2020-10-26 21:34:45
110	Lanarkshire	2	2020-10-26 21:34:45
111	Lancashire	2	2020-10-26 21:34:45
112	Leicestershire	2	2020-10-26 21:34:45
113	Lincolnshire	2	2020-10-26 21:34:45
114	Llanymynech	2	2020-10-26 21:34:45
115	London	2	2020-10-26 21:34:45
116	Ludlow	2	2020-10-26 21:34:45
117	Manchester	2	2020-10-26 21:34:45
118	Mayfair	2	2020-10-26 21:34:45
119	Merseyside	2	2020-10-26 21:34:45
120	Mid Glamorgan	2	2020-10-26 21:34:45
121	Middlesex	2	2020-10-26 21:34:45
122	Mildenhall	2	2020-10-26 21:34:45
123	Monmouthshire	2	2020-10-26 21:34:45
124	Newton Stewart	2	2020-10-26 21:34:45
125	Norfolk	2	2020-10-26 21:34:45
126	North Humberside	2	2020-10-26 21:34:45
127	North Yorkshire	2	2020-10-26 21:34:45
128	Northamptonshire	2	2020-10-26 21:34:45
129	Northants	2	2020-10-26 21:34:45
130	Northern Ireland	2	2020-10-26 21:34:45
131	Northumberland	2	2020-10-26 21:34:45
132	Nottinghamshire	2	2020-10-26 21:34:45
133	Oxford	2	2020-10-26 21:34:45
134	Powys	2	2020-10-26 21:34:45
135	Roos-shire	2	2020-10-26 21:34:45
136	SUSSEX	2	2020-10-26 21:34:45
137	Sark	2	2020-10-26 21:34:45
138	Scotland	2	2020-10-26 21:34:45
139	Scottish Borders	2	2020-10-26 21:34:45
140	Shropshire	2	2020-10-26 21:34:45
141	Somerset	2	2020-10-26 21:34:45
142	South Glamorgan	2	2020-10-26 21:34:45
143	South Wales	2	2020-10-26 21:34:45
144	South Yorkshire	2	2020-10-26 21:34:45
145	Southwell	2	2020-10-26 21:34:45
146	Staffordshire	2	2020-10-26 21:34:45
147	Strabane	2	2020-10-26 21:34:45
148	Suffolk	2	2020-10-26 21:34:45
149	Surrey	2	2020-10-26 21:34:45
150	Sussex	2	2020-10-26 21:34:45
151	Twickenham	2	2020-10-26 21:34:45
152	Tyne and Wear	2	2020-10-26 21:34:45
153	Tyrone	2	2020-10-26 21:34:45
154	Utah	2	2020-10-26 21:34:45
155	Wales	2	2020-10-26 21:34:45
156	Warwickshire	2	2020-10-26 21:34:45
157	West Lothian	2	2020-10-26 21:34:45
158	West Midlands	2	2020-10-26 21:34:45
159	West Sussex	2	2020-10-26 21:34:45
160	West Yorkshire	2	2020-10-26 21:34:45
161	Whissendine	2	2020-10-26 21:34:45
162	Wiltshire	2	2020-10-26 21:34:45
163	Wokingham	2	2020-10-26 21:34:45
164	Worcestershire	2	2020-10-26 21:34:45
165	Wrexham	2	2020-10-26 21:34:45
166	Wurttemberg	2	2020-10-26 21:34:45
167	Yorkshire	2	2020-10-26 21:34:45
168	Auvergne	3	2020-10-26 21:34:45
169	Baden-Wurttemberg	3	2020-10-26 21:34:45
170	Bavaria	3	2020-10-26 21:34:45
171	Bayern	3	2020-10-26 21:34:45
172	Beilstein Wurtt	3	2020-10-26 21:34:45
173	Berlin	3	2020-10-26 21:34:45
174	Brandenburg	3	2020-10-26 21:34:45
175	Bremen	3	2020-10-26 21:34:45
176	Dreisbach	3	2020-10-26 21:34:45
177	Freistaat Bayern	3	2020-10-26 21:34:45
178	Hamburg	3	2020-10-26 21:34:45
179	Hannover	3	2020-10-26 21:34:45
180	Heroldstatt	3	2020-10-26 21:34:45
181	Hessen	3	2020-10-26 21:34:45
182	Kortenberg	3	2020-10-26 21:34:45
183	Laasdorf	3	2020-10-26 21:34:45
184	Land Baden-Wurttemberg	3	2020-10-26 21:34:45
185	Land Bayern	3	2020-10-26 21:34:45
186	Land Brandenburg	3	2020-10-26 21:34:45
187	Land Hessen	3	2020-10-26 21:34:45
188	Land Mecklenburg-Vorpommern	3	2020-10-26 21:34:45
189	Land Nordrhein-Westfalen	3	2020-10-26 21:34:45
190	Land Rheinland-Pfalz	3	2020-10-26 21:34:45
191	Land Sachsen	3	2020-10-26 21:34:45
192	Land Sachsen-Anhalt	3	2020-10-26 21:34:45
193	Land Thuringen	3	2020-10-26 21:34:45
194	Lower Saxony	3	2020-10-26 21:34:45
195	Mecklenburg-Vorpommern	3	2020-10-26 21:34:45
196	Mulfingen	3	2020-10-26 21:34:45
197	Munich	3	2020-10-26 21:34:45
198	Neubeuern	3	2020-10-26 21:34:45
199	Niedersachsen	3	2020-10-26 21:34:45
200	Noord-Holland	3	2020-10-26 21:34:45
201	Nordrhein-Westfalen	3	2020-10-26 21:34:45
202	North Rhine-Westphalia	3	2020-10-26 21:34:45
203	Osterode	3	2020-10-26 21:34:45
204	Rheinland-Pfalz	3	2020-10-26 21:34:45
205	Rhineland-Palatinate	3	2020-10-26 21:34:45
206	Saarland	3	2020-10-26 21:34:45
207	Sachsen	3	2020-10-26 21:34:45
208	Sachsen-Anhalt	3	2020-10-26 21:34:45
209	Saxony	3	2020-10-26 21:34:45
210	Schleswig-Holstein	3	2020-10-26 21:34:45
211	Thuringia	3	2020-10-26 21:34:45
212	Webling	3	2020-10-26 21:34:45
213	Weinstrabe	3	2020-10-26 21:34:45
214	schlobborn	3	2020-10-26 21:34:45
215	Ain	4	2020-10-26 21:34:45
216	Aisne	4	2020-10-26 21:34:45
217	Albi Le Sequestre	4	2020-10-26 21:34:45
218	Allier	4	2020-10-26 21:34:45
219	Alpes-Cote dAzur	4	2020-10-26 21:34:45
220	Alpes-Maritimes	4	2020-10-26 21:34:45
221	Alpes-de-Haute-Provence	4	2020-10-26 21:34:45
222	Alsace	4	2020-10-26 21:34:45
223	Aquitaine	4	2020-10-26 21:34:45
224	Ardeche	4	2020-10-26 21:34:45
225	Ardennes	4	2020-10-26 21:34:45
226	Ariege	4	2020-10-26 21:34:45
227	Aube	4	2020-10-26 21:34:45
228	Aude	4	2020-10-26 21:34:45
229	Auvergne	4	2020-10-26 21:34:45
230	Aveyron	4	2020-10-26 21:34:45
231	Bas-Rhin	4	2020-10-26 21:34:45
232	Basse-Normandie	4	2020-10-26 21:34:45
233	Bouches-du-Rhone	4	2020-10-26 21:34:45
234	Bourgogne	4	2020-10-26 21:34:45
235	Bretagne	4	2020-10-26 21:34:45
236	Brittany	4	2020-10-26 21:34:45
237	Burgundy	4	2020-10-26 21:34:45
238	Calvados	4	2020-10-26 21:34:45
239	Cantal	4	2020-10-26 21:34:45
240	Cedex	4	2020-10-26 21:34:45
241	Centre	4	2020-10-26 21:34:45
242	Charente	4	2020-10-26 21:34:45
243	Charente-Maritime	4	2020-10-26 21:34:45
244	Cher	4	2020-10-26 21:34:45
245	Correze	4	2020-10-26 21:34:45
246	Corse-du-Sud	4	2020-10-26 21:34:45
247	Cote-d'Or	4	2020-10-26 21:34:45
248	Cotes-d'Armor	4	2020-10-26 21:34:45
249	Creuse	4	2020-10-26 21:34:45
250	Crolles	4	2020-10-26 21:34:45
251	Deux-Sevres	4	2020-10-26 21:34:45
252	Dordogne	4	2020-10-26 21:34:45
253	Doubs	4	2020-10-26 21:34:45
254	Drome	4	2020-10-26 21:34:45
255	Essonne	4	2020-10-26 21:34:45
256	Eure	4	2020-10-26 21:34:45
257	Eure-et-Loir	4	2020-10-26 21:34:45
258	Feucherolles	4	2020-10-26 21:34:45
259	Finistere	4	2020-10-26 21:34:45
260	Franche-Comte	4	2020-10-26 21:34:45
261	Gard	4	2020-10-26 21:34:45
262	Gers	4	2020-10-26 21:34:45
263	Gironde	4	2020-10-26 21:34:45
264	Haut-Rhin	4	2020-10-26 21:34:45
265	Haute-Corse	4	2020-10-26 21:34:45
266	Haute-Garonne	4	2020-10-26 21:34:45
267	Haute-Loire	4	2020-10-26 21:34:45
268	Haute-Marne	4	2020-10-26 21:34:45
269	Haute-Saone	4	2020-10-26 21:34:45
270	Haute-Savoie	4	2020-10-26 21:34:45
271	Haute-Vienne	4	2020-10-26 21:34:45
272	Hautes-Alpes	4	2020-10-26 21:34:45
273	Hautes-Pyrenees	4	2020-10-26 21:34:45
274	Hauts-de-Seine	4	2020-10-26 21:34:45
275	Herault	4	2020-10-26 21:34:45
276	Ile-de-France	4	2020-10-26 21:34:45
277	Ille-et-Vilaine	4	2020-10-26 21:34:45
278	Indre	4	2020-10-26 21:34:45
279	Indre-et-Loire	4	2020-10-26 21:34:45
280	Isere	4	2020-10-26 21:34:45
281	Jura	4	2020-10-26 21:34:45
282	Klagenfurt	4	2020-10-26 21:34:45
283	Landes	4	2020-10-26 21:34:45
284	Languedoc-Roussillon	4	2020-10-26 21:34:45
285	Larcay	4	2020-10-26 21:34:45
286	Le Castellet	4	2020-10-26 21:34:45
287	Le Creusot	4	2020-10-26 21:34:45
288	Limousin	4	2020-10-26 21:34:45
289	Loir-et-Cher	4	2020-10-26 21:34:45
290	Loire	4	2020-10-26 21:34:45
291	Loire-Atlantique	4	2020-10-26 21:34:45
292	Loiret	4	2020-10-26 21:34:45
293	Lorraine	4	2020-10-26 21:34:45
294	Lot	4	2020-10-26 21:34:45
295	Lot-et-Garonne	4	2020-10-26 21:34:45
296	Lower Normandy	4	2020-10-26 21:34:45
297	Lozere	4	2020-10-26 21:34:45
298	Maine-et-Loire	4	2020-10-26 21:34:45
299	Manche	4	2020-10-26 21:34:45
300	Marne	4	2020-10-26 21:34:45
301	Mayenne	4	2020-10-26 21:34:45
302	Meurthe-et-Moselle	4	2020-10-26 21:34:45
303	Meuse	4	2020-10-26 21:34:45
304	Midi-Pyrenees	4	2020-10-26 21:34:45
305	Morbihan	4	2020-10-26 21:34:45
306	Moselle	4	2020-10-26 21:34:45
307	Nievre	4	2020-10-26 21:34:45
308	Nord	4	2020-10-26 21:34:45
309	Nord-Pas-de-Calais	4	2020-10-26 21:34:45
310	Oise	4	2020-10-26 21:34:45
311	Orne	4	2020-10-26 21:34:45
312	Paris	4	2020-10-26 21:34:45
313	Pas-de-Calais	4	2020-10-26 21:34:45
314	Pays de la Loire	4	2020-10-26 21:34:45
315	Pays-de-la-Loire	4	2020-10-26 21:34:45
316	Picardy	4	2020-10-26 21:34:45
317	Puy-de-Dome	4	2020-10-26 21:34:45
318	Pyrenees-Atlantiques	4	2020-10-26 21:34:45
319	Pyrenees-Orientales	4	2020-10-26 21:34:45
320	Quelmes	4	2020-10-26 21:34:45
321	Rhone	4	2020-10-26 21:34:45
322	Rhone-Alpes	4	2020-10-26 21:34:45
323	Saint Ouen	4	2020-10-26 21:34:45
324	Saint Viatre	4	2020-10-26 21:34:45
325	Saone-et-Loire	4	2020-10-26 21:34:45
326	Sarthe	4	2020-10-26 21:34:45
327	Savoie	4	2020-10-26 21:34:45
328	Seine-Maritime	4	2020-10-26 21:34:45
329	Seine-Saint-Denis	4	2020-10-26 21:34:45
330	Seine-et-Marne	4	2020-10-26 21:34:45
331	Somme	4	2020-10-26 21:34:45
332	Sophia Antipolis	4	2020-10-26 21:34:45
333	Souvans	4	2020-10-26 21:34:45
334	Tarn	4	2020-10-26 21:34:45
335	Tarn-et-Garonne	4	2020-10-26 21:34:45
336	Territoire de Belfort	4	2020-10-26 21:34:45
337	Treignac	4	2020-10-26 21:34:45
338	Upper Normandy	4	2020-10-26 21:34:45
339	Val-d'Oise	4	2020-10-26 21:34:45
340	Val-de-Marne	4	2020-10-26 21:34:45
341	Var	4	2020-10-26 21:34:45
342	Vaucluse	4	2020-10-26 21:34:45
343	Vellise	4	2020-10-26 21:34:45
344	Vendee	4	2020-10-26 21:34:45
345	Vienne	4	2020-10-26 21:34:45
346	Vosges	4	2020-10-26 21:34:45
347	Yonne	4	2020-10-26 21:34:45
348	Yvelines	4	2020-10-26 21:34:45
349	Abrantes	5	2020-10-26 21:34:45
350	Acores	5	2020-10-26 21:34:45
351	Alentejo	5	2020-10-26 21:34:45
352	Algarve	5	2020-10-26 21:34:45
353	Braga	5	2020-10-26 21:34:45
354	Centro	5	2020-10-26 21:34:45
355	Distrito de Leiria	5	2020-10-26 21:34:45
356	Distrito de Viana do Castelo	5	2020-10-26 21:34:45
357	Distrito de Vila Real	5	2020-10-26 21:34:45
358	Distrito do Porto	5	2020-10-26 21:34:45
359	Lisboa e Vale do Tejo	5	2020-10-26 21:34:45
360	Madeira	5	2020-10-26 21:34:45
361	Norte	5	2020-10-26 21:34:45
362	Paivas	5	2020-10-26 21:34:45
\.


--
-- Data for Name: statuses; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.statuses (id, label, created_at) FROM stdin;
1	Borrado	2020-10-26 21:34:45
2	Inactivo	2020-10-26 21:34:45
3	Activo	2020-10-26 21:34:45
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.users (id, username, password, email, auth_key, verf_key, status_id, admin, privacity, name, surname, birthdate, image, rol_id, language_id, updated_at, created_at) FROM stdin;
1	admin	$2a$10$4MUBSGT2/DmXnRjFn86FjOZYkh3UMTj1RaJOXyFFEefqTifRv8sO2	alonsorgr@venenciame.com	\N	\N	3	t	f	Alonso	García	1983-05-25	admin.jpg	1	1	\N	2020-10-26 21:34:45
2	paula	$2a$10$0wXf35r3cR/ebwhfYacdSOpMiW6jWTqRHtMABGyry46Duw.Y3Bn0y	paula@venenciame.com	\N	\N	3	f	f	Paula	Suárez	1990-11-12	paula.jpg	1	1	\N	2020-10-26 21:34:45
\.


--
-- Data for Name: vats; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.vats (id, label, value, created_at) FROM stdin;
1	IVA del 10%	10	2020-10-26 21:34:46
2	IVA del 21%	21	2020-10-26 21:34:46
\.


--
-- Name: articles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.articles_id_seq', 2, true);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.categories_id_seq', 10, true);


--
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.countries_id_seq', 5, true);


--
-- Name: denominations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.denominations_id_seq', 8, true);


--
-- Name: favorites_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.favorites_id_seq', 4, true);


--
-- Name: followers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.followers_id_seq', 4, true);


--
-- Name: languages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.languages_id_seq', 5, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.notifications_id_seq', 8, true);


--
-- Name: partners_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.partners_id_seq', 2, true);


--
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.reviews_id_seq', 4, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.roles_id_seq', 3, true);


--
-- Name: states_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.states_id_seq', 362, true);


--
-- Name: statuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.statuses_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: vats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.vats_id_seq', 2, true);


--
-- Name: articles articles_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_pkey PRIMARY KEY (id);


--
-- Name: categories categories_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_label_key UNIQUE (label);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- Name: denominations denominations_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations
    ADD CONSTRAINT denominations_label_key UNIQUE (label);


--
-- Name: denominations denominations_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations
    ADD CONSTRAINT denominations_pkey PRIMARY KEY (id);


--
-- Name: favorites favorites_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_pkey PRIMARY KEY (id);


--
-- Name: followers followers_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_pkey PRIMARY KEY (id);


--
-- Name: languages languages_code_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_code_key UNIQUE (code);


--
-- Name: languages languages_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_label_key UNIQUE (label);


--
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (id);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: partners partners_name_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_name_key UNIQUE (name);


--
-- Name: partners partners_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_pkey PRIMARY KEY (id);


--
-- Name: partners partners_user_id_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_user_id_key UNIQUE (user_id);


--
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- Name: reviews reviews_user_id_article_id_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_article_id_key UNIQUE (user_id, article_id);


--
-- Name: roles roles_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_label_key UNIQUE (label);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: states states_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_pkey PRIMARY KEY (id);


--
-- Name: statuses statuses_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses
    ADD CONSTRAINT statuses_label_key UNIQUE (label);


--
-- Name: statuses statuses_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses
    ADD CONSTRAINT statuses_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: vats vats_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_label_key UNIQUE (label);


--
-- Name: vats vats_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_pkey PRIMARY KEY (id);


--
-- Name: vats vats_value_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_value_key UNIQUE (value);


--
-- Name: index_2; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_2 ON public.notifications USING btree (user_id);


--
-- Name: index_3; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_3 ON public.notifications USING btree (created_at);


--
-- Name: index_4; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_4 ON public.notifications USING btree (seen);


--
-- Name: articles articles_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_denomination_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_denomination_id_fkey FOREIGN KEY (denomination_id) REFERENCES public.denominations(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_partner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_partner_id_fkey FOREIGN KEY (partner_id) REFERENCES public.partners(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_vat_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_vat_id_fkey FOREIGN KEY (vat_id) REFERENCES public.vats(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: favorites favorites_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.articles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: favorites favorites_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: followers followers_partner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_partner_id_fkey FOREIGN KEY (partner_id) REFERENCES public.partners(id);


--
-- Name: followers followers_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: partners partners_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_country_id_fkey FOREIGN KEY (country_id) REFERENCES public.countries(id);


--
-- Name: partners partners_state_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_state_id_fkey FOREIGN KEY (state_id) REFERENCES public.states(id);


--
-- Name: partners partners_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id);


--
-- Name: partners partners_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: reviews reviews_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.articles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: reviews reviews_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: states states_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_country_id_fkey FOREIGN KEY (country_id) REFERENCES public.countries(id);


--
-- Name: users users_language_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_language_id_fkey FOREIGN KEY (language_id) REFERENCES public.languages(id);


--
-- Name: users users_rol_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_rol_id_fkey FOREIGN KEY (rol_id) REFERENCES public.roles(id);


--
-- Name: users users_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id);


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 12.4 (Ubuntu 12.4-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.4 (Ubuntu 12.4-1.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: articles; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.articles (
    id bigint NOT NULL,
    partner_id bigint NOT NULL,
    category_id bigint NOT NULL,
    denomination_id bigint NOT NULL,
    vat_id bigint NOT NULL,
    status_id bigint DEFAULT 2,
    title character varying(50) NOT NULL,
    description character varying(255) NOT NULL,
    price numeric NOT NULL,
    stock integer NOT NULL,
    degrees character varying(50) NOT NULL,
    capacity integer NOT NULL,
    variety character varying(50) NOT NULL,
    pairing character varying(50) NOT NULL,
    review text NOT NULL,
    image character varying(255) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.articles OWNER TO venenciame;

--
-- Name: articles_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.articles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.articles_id_seq OWNER TO venenciame;

--
-- Name: articles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.articles_id_seq OWNED BY public.articles.id;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.categories OWNER TO venenciame;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_id_seq OWNER TO venenciame;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: countries; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.countries (
    id bigint NOT NULL,
    code character varying(2) NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.countries OWNER TO venenciame;

--
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.countries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_id_seq OWNER TO venenciame;

--
-- Name: countries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.countries_id_seq OWNED BY public.countries.id;


--
-- Name: denominations; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.denominations (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.denominations OWNER TO venenciame;

--
-- Name: denominations_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.denominations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.denominations_id_seq OWNER TO venenciame;

--
-- Name: denominations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.denominations_id_seq OWNED BY public.denominations.id;


--
-- Name: favorites; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.favorites (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    article_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.favorites OWNER TO venenciame;

--
-- Name: favorites_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.favorites_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.favorites_id_seq OWNER TO venenciame;

--
-- Name: favorites_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.favorites_id_seq OWNED BY public.favorites.id;


--
-- Name: followers; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.followers (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    partner_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.followers OWNER TO venenciame;

--
-- Name: followers_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.followers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.followers_id_seq OWNER TO venenciame;

--
-- Name: followers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.followers_id_seq OWNED BY public.followers.id;


--
-- Name: languages; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.languages (
    id bigint NOT NULL,
    code character varying(2) NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.languages OWNER TO venenciame;

--
-- Name: languages_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.languages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_id_seq OWNER TO venenciame;

--
-- Name: languages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.languages_id_seq OWNED BY public.languages.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO venenciame;

--
-- Name: notifications; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.notifications (
    id integer NOT NULL,
    class character varying(64) NOT NULL,
    key character varying(32) NOT NULL,
    message character varying(255) NOT NULL,
    route character varying(255) NOT NULL,
    seen boolean DEFAULT false NOT NULL,
    read boolean DEFAULT false NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    created_at integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.notifications OWNER TO venenciame;

--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO venenciame;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: partners; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.partners (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(32) NOT NULL,
    description character varying(255),
    information text,
    image character varying(255),
    country_id bigint NOT NULL,
    state_id bigint NOT NULL,
    status_id bigint,
    city character varying(64) NOT NULL,
    zip_code character varying(64) NOT NULL,
    address character varying(64) NOT NULL,
    phone character varying(64) NOT NULL,
    url character varying(64),
    email character varying(64),
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.partners OWNER TO venenciame;

--
-- Name: partners_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.partners_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partners_id_seq OWNER TO venenciame;

--
-- Name: partners_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.partners_id_seq OWNED BY public.partners.id;


--
-- Name: reviews; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.reviews (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    article_id bigint NOT NULL,
    review text NOT NULL,
    score integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT ck_value_min_max CHECK (((score >= 0) AND (score <= 5)))
);


ALTER TABLE public.reviews OWNER TO venenciame;

--
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviews_id_seq OWNER TO venenciame;

--
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.roles OWNER TO venenciame;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO venenciame;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: states; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.states (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    country_id bigint,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.states OWNER TO venenciame;

--
-- Name: states_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.states_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.states_id_seq OWNER TO venenciame;

--
-- Name: states_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.states_id_seq OWNED BY public.states.id;


--
-- Name: statuses; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.statuses (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.statuses OWNER TO venenciame;

--
-- Name: statuses_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.statuses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.statuses_id_seq OWNER TO venenciame;

--
-- Name: statuses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.statuses_id_seq OWNED BY public.statuses.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    username character varying(32) NOT NULL,
    password character varying(64) NOT NULL,
    email character varying(64) NOT NULL,
    auth_key character varying(32) DEFAULT NULL::character varying,
    verf_key character varying(32) DEFAULT NULL::character varying,
    status_id bigint,
    admin boolean DEFAULT false,
    privacity boolean DEFAULT false,
    name character varying(32),
    surname character varying(32),
    birthdate date,
    image character varying(255),
    rol_id bigint,
    language_id bigint,
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO venenciame;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO venenciame;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: vats; Type: TABLE; Schema: public; Owner: venenciame
--

CREATE TABLE public.vats (
    id bigint NOT NULL,
    label character varying(64) NOT NULL,
    value integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.vats OWNER TO venenciame;

--
-- Name: vats_id_seq; Type: SEQUENCE; Schema: public; Owner: venenciame
--

CREATE SEQUENCE public.vats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vats_id_seq OWNER TO venenciame;

--
-- Name: vats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: venenciame
--

ALTER SEQUENCE public.vats_id_seq OWNED BY public.vats.id;


--
-- Name: articles id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles ALTER COLUMN id SET DEFAULT nextval('public.articles_id_seq'::regclass);


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: countries id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.countries ALTER COLUMN id SET DEFAULT nextval('public.countries_id_seq'::regclass);


--
-- Name: denominations id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations ALTER COLUMN id SET DEFAULT nextval('public.denominations_id_seq'::regclass);


--
-- Name: favorites id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites ALTER COLUMN id SET DEFAULT nextval('public.favorites_id_seq'::regclass);


--
-- Name: followers id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers ALTER COLUMN id SET DEFAULT nextval('public.followers_id_seq'::regclass);


--
-- Name: languages id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages ALTER COLUMN id SET DEFAULT nextval('public.languages_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: partners id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners ALTER COLUMN id SET DEFAULT nextval('public.partners_id_seq'::regclass);


--
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: states id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states ALTER COLUMN id SET DEFAULT nextval('public.states_id_seq'::regclass);


--
-- Name: statuses id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses ALTER COLUMN id SET DEFAULT nextval('public.statuses_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: vats id; Type: DEFAULT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats ALTER COLUMN id SET DEFAULT nextval('public.vats_id_seq'::regclass);


--
-- Data for Name: articles; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.articles (id, partner_id, category_id, denomination_id, vat_id, status_id, title, description, price, stock, degrees, capacity, variety, pairing, review, image, created_at) FROM stdin;
1	1	7	4	2	3	Gitana	Una manzanilla fresca para beber.	5.50	10000	15	75	100% Palomino fino	Tapas, pescados, mariscos, ahumados.	Color: pajizo. Aroma: equilibrado, fresco, salino, expresivo, punzante. Boca: sabroso, fino amargor, largo. 	Gitana.jpg	2020-10-26 21:52:22
2	1	2	2	2	3	 Valdespino Palo Cortado Cardenal VORS	Fino Inocente y del amontillado Tío Diego	195	10	20.5	75	100% Palomino fino	Ahumados, frutos secos, quesos curados.	The Cardenal may be showing its age a little, but the intensity is unfailing, overlaid with honeyed, buttery notes. The palate is vivid and very long. Memorable.	 Valdespino Palo Cortado Cardenal VORS.jpg	2020-10-26 22:00:38
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.categories (id, label, created_at) FROM stdin;
1	Tinto	2020-10-26 21:34:46
2	Blanco	2020-10-26 21:34:46
3	Espumoso	2020-10-26 21:34:46
4	Generoso	2020-10-26 21:34:46
5	Dulce	2020-10-26 21:34:46
6	Rosado	2020-10-26 21:34:46
7	Manzanilla	2020-10-26 21:34:46
8	Fino	2020-10-26 21:34:46
9	Vermouth	2020-10-26 21:34:46
10	Vino Azul	2020-10-26 21:34:46
\.


--
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.countries (id, code, label, created_at) FROM stdin;
1	ES	España	2020-10-26 21:34:45
2	GB	United Kingdom	2020-10-26 21:34:45
3	DE	Germany	2020-10-26 21:34:45
4	FR	France	2020-10-26 21:34:45
5	PT	Portugal	2020-10-26 21:34:45
\.


--
-- Data for Name: denominations; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.denominations (id, label, created_at) FROM stdin;
1	Condado de Huelva	2020-10-26 21:34:46
2	Jerez-Sherry-Xérès	2020-10-26 21:34:46
3	Málaga	2020-10-26 21:34:46
4	Manzanilla de Sanlúcar	2020-10-26 21:34:46
5	Montilla-Moriles	2020-10-26 21:34:46
6	Lebrija	2020-10-26 21:34:46
7	Sierras de Málaga	2020-10-26 21:34:46
8	Vino Naranja del Condado de Huelva	2020-10-26 21:34:46
\.


--
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.favorites (id, user_id, article_id, created_at) FROM stdin;
1	2	2	2020-10-26 22:00:43
2	2	1	2020-10-26 22:01:36
3	1	2	2020-10-26 22:02:37
4	1	1	2020-10-26 22:03:09
\.


--
-- Data for Name: followers; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.followers (id, user_id, partner_id, created_at) FROM stdin;
1	1	1	2020-10-26 21:39:55
2	1	2	2020-10-26 21:47:13
3	2	1	2020-10-26 21:48:01
4	2	2	2020-10-26 21:48:09
\.


--
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.languages (id, code, label, created_at) FROM stdin;
1	ES	Español	2020-10-26 21:34:45
2	EN	English	2020-10-26 21:34:45
3	GE	Deutsche	2020-10-26 21:34:45
4	FR	Français	2020-10-26 21:34:45
5	PT	Português	2020-10-26 21:34:45
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1602533790
m010101_100001_init_notifications	1602533796
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.notifications (id, class, key, message, route, seen, read, user_id, created_at) FROM stdin;
1	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534093
2	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534112
3	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534244
4	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534259
5	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534267
6	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534292
7	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534295
8	account	reset_password	Instructions to reset the password	a:2:{i:0;s:11:"/users/edit";s:2:"id";i:1;}	t	f	0	1602534325
\.


--
-- Data for Name: partners; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.partners (id, user_id, name, description, information, image, country_id, state_id, status_id, city, zip_code, address, phone, url, email, updated_at, created_at) FROM stdin;
1	1	La Gitana	Bodegas HIDALGO LA GITANA	Bodegas HIDALGO LA GITANA fue fundada en 1792 y desde entonces la firma ha pasado de padres a hijos, siendo hoy una de las pocas empresas vinateras del marco, gestionada por la familia y dirigida por la octava generación en línea directa del fundador.	1.jpg	1	1	3	Sanlúcar de Barrameda	11540	Avenida del Ejercito Nº2	+34637669147	https://lagitana.es/	contacto@lagitana.es	\N	2020-10-26 21:39:23
2	2	José Estévez	Establecida en 1809 y dedicada a la crianza de Jerez y Brandies	Las Bodegas José Estévez S.A. son los sucesores de la firma José Leña Rendón y Compañía, establecida en 1809 y dedicada a la crianza de Jerez y Brandies.	2.jpg	1	13	3	Jeréz de la Frontera	11408	Carretera Nacional IV Km 640	+34636987458	grupoestevez.es	contacto@joseestevez.es	\N	2020-10-26 21:43:54
\.


--
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.reviews (id, user_id, article_id, review, score, created_at) FROM stdin;
1	1	1	Maravillosa Manzanilla.	5	2020-10-26 22:11:35
2	1	2	Muy bueno pero muy caro.	1	2020-10-26 22:12:11
3	2	1	Me encanta, pero me gustan otras Manzanillas más.	2	2020-10-26 22:13:47
4	2	2	Me encanta este vino, pero algo caro.	4	2020-10-26 22:15:01
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.roles (id, label, updated_at, created_at) FROM stdin;
1	Administrador	\N	2020-10-26 21:34:45
2	Cliente	\N	2020-10-26 21:34:45
3	Usuario	\N	2020-10-26 21:34:45
\.


--
-- Data for Name: states; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.states (id, label, country_id, created_at) FROM stdin;
1	A Coruna	1	2020-10-26 21:34:45
2	Alacant	1	2020-10-26 21:34:45
3	Alava	1	2020-10-26 21:34:45
4	Albacete	1	2020-10-26 21:34:45
5	Almeria	1	2020-10-26 21:34:45
6	Asturias	1	2020-10-26 21:34:45
7	Avila	1	2020-10-26 21:34:45
8	Badajoz	1	2020-10-26 21:34:45
9	Balears	1	2020-10-26 21:34:45
10	Barcelona	1	2020-10-26 21:34:45
11	Burgos	1	2020-10-26 21:34:45
12	Caceres	1	2020-10-26 21:34:45
13	Cadiz	1	2020-10-26 21:34:45
14	Cantabria	1	2020-10-26 21:34:45
15	Castello	1	2020-10-26 21:34:45
16	Ceuta	1	2020-10-26 21:34:45
17	Ciudad Real	1	2020-10-26 21:34:45
18	Cordoba	1	2020-10-26 21:34:45
19	Cuenca	1	2020-10-26 21:34:45
20	Girona	1	2020-10-26 21:34:45
21	Granada	1	2020-10-26 21:34:45
22	Guadalajara	1	2020-10-26 21:34:45
23	Guipuzcoa	1	2020-10-26 21:34:45
24	Huelva	1	2020-10-26 21:34:45
25	Huesca	1	2020-10-26 21:34:45
26	Jaen	1	2020-10-26 21:34:45
27	La Rioja	1	2020-10-26 21:34:45
28	Las Palmas	1	2020-10-26 21:34:45
29	Leon	1	2020-10-26 21:34:45
30	Lleida	1	2020-10-26 21:34:45
31	Lugo	1	2020-10-26 21:34:45
32	Madrid	1	2020-10-26 21:34:45
33	Malaga	1	2020-10-26 21:34:45
34	Melilla	1	2020-10-26 21:34:45
35	Murcia	1	2020-10-26 21:34:45
36	Navarra	1	2020-10-26 21:34:45
37	Ourense	1	2020-10-26 21:34:45
38	Pais Vasco	1	2020-10-26 21:34:45
39	Palencia	1	2020-10-26 21:34:45
40	Pontevedra	1	2020-10-26 21:34:45
41	Salamanca	1	2020-10-26 21:34:45
42	Segovia	1	2020-10-26 21:34:45
43	Sevilla	1	2020-10-26 21:34:45
44	Soria	1	2020-10-26 21:34:45
45	Tarragona	1	2020-10-26 21:34:45
46	Santa Cruz de Tenerife	1	2020-10-26 21:34:45
47	Teruel	1	2020-10-26 21:34:45
48	Toledo	1	2020-10-26 21:34:45
49	Valencia	1	2020-10-26 21:34:45
50	Valladolid	1	2020-10-26 21:34:45
51	Vizcaya	1	2020-10-26 21:34:45
52	Zamora	1	2020-10-26 21:34:45
53	Zaragoza	1	2020-10-26 21:34:45
54	Aberdeen	2	2020-10-26 21:34:45
55	Aberdeenshire	2	2020-10-26 21:34:45
56	Argyll	2	2020-10-26 21:34:45
57	Armagh	2	2020-10-26 21:34:45
58	Bedfordshire	2	2020-10-26 21:34:45
59	Belfast	2	2020-10-26 21:34:45
60	Berkshire	2	2020-10-26 21:34:45
61	Birmingham	2	2020-10-26 21:34:45
62	Brechin	2	2020-10-26 21:34:45
63	Bridgnorth	2	2020-10-26 21:34:45
64	Bristol	2	2020-10-26 21:34:45
65	Buckinghamshire	2	2020-10-26 21:34:45
66	Cambridge	2	2020-10-26 21:34:45
67	Cambridgeshire	2	2020-10-26 21:34:45
68	Channel Islands	2	2020-10-26 21:34:45
69	Cheshire	2	2020-10-26 21:34:45
70	Cleveland	2	2020-10-26 21:34:45
71	Co Fermanagh	2	2020-10-26 21:34:45
72	Conwy	2	2020-10-26 21:34:45
73	Cornwall	2	2020-10-26 21:34:45
74	Coventry	2	2020-10-26 21:34:45
75	Craven Arms	2	2020-10-26 21:34:45
76	Cumbria	2	2020-10-26 21:34:45
77	Denbighshire	2	2020-10-26 21:34:45
78	Derby	2	2020-10-26 21:34:45
79	Derbyshire	2	2020-10-26 21:34:45
80	Devon	2	2020-10-26 21:34:45
81	Dial Code Dungannon	2	2020-10-26 21:34:45
82	Didcot	2	2020-10-26 21:34:45
83	Dorset	2	2020-10-26 21:34:45
84	Dunbartonshire	2	2020-10-26 21:34:45
85	Durham	2	2020-10-26 21:34:45
86	East Dunbartonshire	2	2020-10-26 21:34:45
87	East Lothian	2	2020-10-26 21:34:45
88	East Midlands	2	2020-10-26 21:34:45
89	East Sussex	2	2020-10-26 21:34:45
90	East Yorkshire	2	2020-10-26 21:34:45
91	England	2	2020-10-26 21:34:45
92	Essex	2	2020-10-26 21:34:45
93	Fermanagh	2	2020-10-26 21:34:45
94	Fife	2	2020-10-26 21:34:45
95	Flintshire	2	2020-10-26 21:34:45
96	Fulham	2	2020-10-26 21:34:45
97	Gainsborough	2	2020-10-26 21:34:45
98	Glocestershire	2	2020-10-26 21:34:45
99	Gwent	2	2020-10-26 21:34:45
100	Hampshire	2	2020-10-26 21:34:45
101	Hants	2	2020-10-26 21:34:45
102	Herefordshire	2	2020-10-26 21:34:45
103	Hertfordshire	2	2020-10-26 21:34:45
104	Ireland	2	2020-10-26 21:34:45
105	Isle Of Man	2	2020-10-26 21:34:45
106	Isle of Wight	2	2020-10-26 21:34:45
107	Kenford	2	2020-10-26 21:34:45
108	Kent	2	2020-10-26 21:34:45
109	Kilmarnock	2	2020-10-26 21:34:45
110	Lanarkshire	2	2020-10-26 21:34:45
111	Lancashire	2	2020-10-26 21:34:45
112	Leicestershire	2	2020-10-26 21:34:45
113	Lincolnshire	2	2020-10-26 21:34:45
114	Llanymynech	2	2020-10-26 21:34:45
115	London	2	2020-10-26 21:34:45
116	Ludlow	2	2020-10-26 21:34:45
117	Manchester	2	2020-10-26 21:34:45
118	Mayfair	2	2020-10-26 21:34:45
119	Merseyside	2	2020-10-26 21:34:45
120	Mid Glamorgan	2	2020-10-26 21:34:45
121	Middlesex	2	2020-10-26 21:34:45
122	Mildenhall	2	2020-10-26 21:34:45
123	Monmouthshire	2	2020-10-26 21:34:45
124	Newton Stewart	2	2020-10-26 21:34:45
125	Norfolk	2	2020-10-26 21:34:45
126	North Humberside	2	2020-10-26 21:34:45
127	North Yorkshire	2	2020-10-26 21:34:45
128	Northamptonshire	2	2020-10-26 21:34:45
129	Northants	2	2020-10-26 21:34:45
130	Northern Ireland	2	2020-10-26 21:34:45
131	Northumberland	2	2020-10-26 21:34:45
132	Nottinghamshire	2	2020-10-26 21:34:45
133	Oxford	2	2020-10-26 21:34:45
134	Powys	2	2020-10-26 21:34:45
135	Roos-shire	2	2020-10-26 21:34:45
136	SUSSEX	2	2020-10-26 21:34:45
137	Sark	2	2020-10-26 21:34:45
138	Scotland	2	2020-10-26 21:34:45
139	Scottish Borders	2	2020-10-26 21:34:45
140	Shropshire	2	2020-10-26 21:34:45
141	Somerset	2	2020-10-26 21:34:45
142	South Glamorgan	2	2020-10-26 21:34:45
143	South Wales	2	2020-10-26 21:34:45
144	South Yorkshire	2	2020-10-26 21:34:45
145	Southwell	2	2020-10-26 21:34:45
146	Staffordshire	2	2020-10-26 21:34:45
147	Strabane	2	2020-10-26 21:34:45
148	Suffolk	2	2020-10-26 21:34:45
149	Surrey	2	2020-10-26 21:34:45
150	Sussex	2	2020-10-26 21:34:45
151	Twickenham	2	2020-10-26 21:34:45
152	Tyne and Wear	2	2020-10-26 21:34:45
153	Tyrone	2	2020-10-26 21:34:45
154	Utah	2	2020-10-26 21:34:45
155	Wales	2	2020-10-26 21:34:45
156	Warwickshire	2	2020-10-26 21:34:45
157	West Lothian	2	2020-10-26 21:34:45
158	West Midlands	2	2020-10-26 21:34:45
159	West Sussex	2	2020-10-26 21:34:45
160	West Yorkshire	2	2020-10-26 21:34:45
161	Whissendine	2	2020-10-26 21:34:45
162	Wiltshire	2	2020-10-26 21:34:45
163	Wokingham	2	2020-10-26 21:34:45
164	Worcestershire	2	2020-10-26 21:34:45
165	Wrexham	2	2020-10-26 21:34:45
166	Wurttemberg	2	2020-10-26 21:34:45
167	Yorkshire	2	2020-10-26 21:34:45
168	Auvergne	3	2020-10-26 21:34:45
169	Baden-Wurttemberg	3	2020-10-26 21:34:45
170	Bavaria	3	2020-10-26 21:34:45
171	Bayern	3	2020-10-26 21:34:45
172	Beilstein Wurtt	3	2020-10-26 21:34:45
173	Berlin	3	2020-10-26 21:34:45
174	Brandenburg	3	2020-10-26 21:34:45
175	Bremen	3	2020-10-26 21:34:45
176	Dreisbach	3	2020-10-26 21:34:45
177	Freistaat Bayern	3	2020-10-26 21:34:45
178	Hamburg	3	2020-10-26 21:34:45
179	Hannover	3	2020-10-26 21:34:45
180	Heroldstatt	3	2020-10-26 21:34:45
181	Hessen	3	2020-10-26 21:34:45
182	Kortenberg	3	2020-10-26 21:34:45
183	Laasdorf	3	2020-10-26 21:34:45
184	Land Baden-Wurttemberg	3	2020-10-26 21:34:45
185	Land Bayern	3	2020-10-26 21:34:45
186	Land Brandenburg	3	2020-10-26 21:34:45
187	Land Hessen	3	2020-10-26 21:34:45
188	Land Mecklenburg-Vorpommern	3	2020-10-26 21:34:45
189	Land Nordrhein-Westfalen	3	2020-10-26 21:34:45
190	Land Rheinland-Pfalz	3	2020-10-26 21:34:45
191	Land Sachsen	3	2020-10-26 21:34:45
192	Land Sachsen-Anhalt	3	2020-10-26 21:34:45
193	Land Thuringen	3	2020-10-26 21:34:45
194	Lower Saxony	3	2020-10-26 21:34:45
195	Mecklenburg-Vorpommern	3	2020-10-26 21:34:45
196	Mulfingen	3	2020-10-26 21:34:45
197	Munich	3	2020-10-26 21:34:45
198	Neubeuern	3	2020-10-26 21:34:45
199	Niedersachsen	3	2020-10-26 21:34:45
200	Noord-Holland	3	2020-10-26 21:34:45
201	Nordrhein-Westfalen	3	2020-10-26 21:34:45
202	North Rhine-Westphalia	3	2020-10-26 21:34:45
203	Osterode	3	2020-10-26 21:34:45
204	Rheinland-Pfalz	3	2020-10-26 21:34:45
205	Rhineland-Palatinate	3	2020-10-26 21:34:45
206	Saarland	3	2020-10-26 21:34:45
207	Sachsen	3	2020-10-26 21:34:45
208	Sachsen-Anhalt	3	2020-10-26 21:34:45
209	Saxony	3	2020-10-26 21:34:45
210	Schleswig-Holstein	3	2020-10-26 21:34:45
211	Thuringia	3	2020-10-26 21:34:45
212	Webling	3	2020-10-26 21:34:45
213	Weinstrabe	3	2020-10-26 21:34:45
214	schlobborn	3	2020-10-26 21:34:45
215	Ain	4	2020-10-26 21:34:45
216	Aisne	4	2020-10-26 21:34:45
217	Albi Le Sequestre	4	2020-10-26 21:34:45
218	Allier	4	2020-10-26 21:34:45
219	Alpes-Cote dAzur	4	2020-10-26 21:34:45
220	Alpes-Maritimes	4	2020-10-26 21:34:45
221	Alpes-de-Haute-Provence	4	2020-10-26 21:34:45
222	Alsace	4	2020-10-26 21:34:45
223	Aquitaine	4	2020-10-26 21:34:45
224	Ardeche	4	2020-10-26 21:34:45
225	Ardennes	4	2020-10-26 21:34:45
226	Ariege	4	2020-10-26 21:34:45
227	Aube	4	2020-10-26 21:34:45
228	Aude	4	2020-10-26 21:34:45
229	Auvergne	4	2020-10-26 21:34:45
230	Aveyron	4	2020-10-26 21:34:45
231	Bas-Rhin	4	2020-10-26 21:34:45
232	Basse-Normandie	4	2020-10-26 21:34:45
233	Bouches-du-Rhone	4	2020-10-26 21:34:45
234	Bourgogne	4	2020-10-26 21:34:45
235	Bretagne	4	2020-10-26 21:34:45
236	Brittany	4	2020-10-26 21:34:45
237	Burgundy	4	2020-10-26 21:34:45
238	Calvados	4	2020-10-26 21:34:45
239	Cantal	4	2020-10-26 21:34:45
240	Cedex	4	2020-10-26 21:34:45
241	Centre	4	2020-10-26 21:34:45
242	Charente	4	2020-10-26 21:34:45
243	Charente-Maritime	4	2020-10-26 21:34:45
244	Cher	4	2020-10-26 21:34:45
245	Correze	4	2020-10-26 21:34:45
246	Corse-du-Sud	4	2020-10-26 21:34:45
247	Cote-d'Or	4	2020-10-26 21:34:45
248	Cotes-d'Armor	4	2020-10-26 21:34:45
249	Creuse	4	2020-10-26 21:34:45
250	Crolles	4	2020-10-26 21:34:45
251	Deux-Sevres	4	2020-10-26 21:34:45
252	Dordogne	4	2020-10-26 21:34:45
253	Doubs	4	2020-10-26 21:34:45
254	Drome	4	2020-10-26 21:34:45
255	Essonne	4	2020-10-26 21:34:45
256	Eure	4	2020-10-26 21:34:45
257	Eure-et-Loir	4	2020-10-26 21:34:45
258	Feucherolles	4	2020-10-26 21:34:45
259	Finistere	4	2020-10-26 21:34:45
260	Franche-Comte	4	2020-10-26 21:34:45
261	Gard	4	2020-10-26 21:34:45
262	Gers	4	2020-10-26 21:34:45
263	Gironde	4	2020-10-26 21:34:45
264	Haut-Rhin	4	2020-10-26 21:34:45
265	Haute-Corse	4	2020-10-26 21:34:45
266	Haute-Garonne	4	2020-10-26 21:34:45
267	Haute-Loire	4	2020-10-26 21:34:45
268	Haute-Marne	4	2020-10-26 21:34:45
269	Haute-Saone	4	2020-10-26 21:34:45
270	Haute-Savoie	4	2020-10-26 21:34:45
271	Haute-Vienne	4	2020-10-26 21:34:45
272	Hautes-Alpes	4	2020-10-26 21:34:45
273	Hautes-Pyrenees	4	2020-10-26 21:34:45
274	Hauts-de-Seine	4	2020-10-26 21:34:45
275	Herault	4	2020-10-26 21:34:45
276	Ile-de-France	4	2020-10-26 21:34:45
277	Ille-et-Vilaine	4	2020-10-26 21:34:45
278	Indre	4	2020-10-26 21:34:45
279	Indre-et-Loire	4	2020-10-26 21:34:45
280	Isere	4	2020-10-26 21:34:45
281	Jura	4	2020-10-26 21:34:45
282	Klagenfurt	4	2020-10-26 21:34:45
283	Landes	4	2020-10-26 21:34:45
284	Languedoc-Roussillon	4	2020-10-26 21:34:45
285	Larcay	4	2020-10-26 21:34:45
286	Le Castellet	4	2020-10-26 21:34:45
287	Le Creusot	4	2020-10-26 21:34:45
288	Limousin	4	2020-10-26 21:34:45
289	Loir-et-Cher	4	2020-10-26 21:34:45
290	Loire	4	2020-10-26 21:34:45
291	Loire-Atlantique	4	2020-10-26 21:34:45
292	Loiret	4	2020-10-26 21:34:45
293	Lorraine	4	2020-10-26 21:34:45
294	Lot	4	2020-10-26 21:34:45
295	Lot-et-Garonne	4	2020-10-26 21:34:45
296	Lower Normandy	4	2020-10-26 21:34:45
297	Lozere	4	2020-10-26 21:34:45
298	Maine-et-Loire	4	2020-10-26 21:34:45
299	Manche	4	2020-10-26 21:34:45
300	Marne	4	2020-10-26 21:34:45
301	Mayenne	4	2020-10-26 21:34:45
302	Meurthe-et-Moselle	4	2020-10-26 21:34:45
303	Meuse	4	2020-10-26 21:34:45
304	Midi-Pyrenees	4	2020-10-26 21:34:45
305	Morbihan	4	2020-10-26 21:34:45
306	Moselle	4	2020-10-26 21:34:45
307	Nievre	4	2020-10-26 21:34:45
308	Nord	4	2020-10-26 21:34:45
309	Nord-Pas-de-Calais	4	2020-10-26 21:34:45
310	Oise	4	2020-10-26 21:34:45
311	Orne	4	2020-10-26 21:34:45
312	Paris	4	2020-10-26 21:34:45
313	Pas-de-Calais	4	2020-10-26 21:34:45
314	Pays de la Loire	4	2020-10-26 21:34:45
315	Pays-de-la-Loire	4	2020-10-26 21:34:45
316	Picardy	4	2020-10-26 21:34:45
317	Puy-de-Dome	4	2020-10-26 21:34:45
318	Pyrenees-Atlantiques	4	2020-10-26 21:34:45
319	Pyrenees-Orientales	4	2020-10-26 21:34:45
320	Quelmes	4	2020-10-26 21:34:45
321	Rhone	4	2020-10-26 21:34:45
322	Rhone-Alpes	4	2020-10-26 21:34:45
323	Saint Ouen	4	2020-10-26 21:34:45
324	Saint Viatre	4	2020-10-26 21:34:45
325	Saone-et-Loire	4	2020-10-26 21:34:45
326	Sarthe	4	2020-10-26 21:34:45
327	Savoie	4	2020-10-26 21:34:45
328	Seine-Maritime	4	2020-10-26 21:34:45
329	Seine-Saint-Denis	4	2020-10-26 21:34:45
330	Seine-et-Marne	4	2020-10-26 21:34:45
331	Somme	4	2020-10-26 21:34:45
332	Sophia Antipolis	4	2020-10-26 21:34:45
333	Souvans	4	2020-10-26 21:34:45
334	Tarn	4	2020-10-26 21:34:45
335	Tarn-et-Garonne	4	2020-10-26 21:34:45
336	Territoire de Belfort	4	2020-10-26 21:34:45
337	Treignac	4	2020-10-26 21:34:45
338	Upper Normandy	4	2020-10-26 21:34:45
339	Val-d'Oise	4	2020-10-26 21:34:45
340	Val-de-Marne	4	2020-10-26 21:34:45
341	Var	4	2020-10-26 21:34:45
342	Vaucluse	4	2020-10-26 21:34:45
343	Vellise	4	2020-10-26 21:34:45
344	Vendee	4	2020-10-26 21:34:45
345	Vienne	4	2020-10-26 21:34:45
346	Vosges	4	2020-10-26 21:34:45
347	Yonne	4	2020-10-26 21:34:45
348	Yvelines	4	2020-10-26 21:34:45
349	Abrantes	5	2020-10-26 21:34:45
350	Acores	5	2020-10-26 21:34:45
351	Alentejo	5	2020-10-26 21:34:45
352	Algarve	5	2020-10-26 21:34:45
353	Braga	5	2020-10-26 21:34:45
354	Centro	5	2020-10-26 21:34:45
355	Distrito de Leiria	5	2020-10-26 21:34:45
356	Distrito de Viana do Castelo	5	2020-10-26 21:34:45
357	Distrito de Vila Real	5	2020-10-26 21:34:45
358	Distrito do Porto	5	2020-10-26 21:34:45
359	Lisboa e Vale do Tejo	5	2020-10-26 21:34:45
360	Madeira	5	2020-10-26 21:34:45
361	Norte	5	2020-10-26 21:34:45
362	Paivas	5	2020-10-26 21:34:45
\.


--
-- Data for Name: statuses; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.statuses (id, label, created_at) FROM stdin;
1	Borrado	2020-10-26 21:34:45
2	Inactivo	2020-10-26 21:34:45
3	Activo	2020-10-26 21:34:45
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.users (id, username, password, email, auth_key, verf_key, status_id, admin, privacity, name, surname, birthdate, image, rol_id, language_id, updated_at, created_at) FROM stdin;
1	admin	$2a$10$4MUBSGT2/DmXnRjFn86FjOZYkh3UMTj1RaJOXyFFEefqTifRv8sO2	alonsorgr@venenciame.com	\N	\N	3	t	f	Alonso	García	1983-05-25	admin.jpg	1	1	\N	2020-10-26 21:34:45
2	paula	$2a$10$0wXf35r3cR/ebwhfYacdSOpMiW6jWTqRHtMABGyry46Duw.Y3Bn0y	paula@venenciame.com	\N	\N	3	f	f	Paula	Suárez	1990-11-12	paula.jpg	1	1	\N	2020-10-26 21:34:45
\.


--
-- Data for Name: vats; Type: TABLE DATA; Schema: public; Owner: venenciame
--

COPY public.vats (id, label, value, created_at) FROM stdin;
1	IVA del 10%	10	2020-10-26 21:34:46
2	IVA del 21%	21	2020-10-26 21:34:46
\.


--
-- Name: articles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.articles_id_seq', 2, true);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.categories_id_seq', 10, true);


--
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.countries_id_seq', 5, true);


--
-- Name: denominations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.denominations_id_seq', 8, true);


--
-- Name: favorites_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.favorites_id_seq', 4, true);


--
-- Name: followers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.followers_id_seq', 4, true);


--
-- Name: languages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.languages_id_seq', 5, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.notifications_id_seq', 8, true);


--
-- Name: partners_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.partners_id_seq', 2, true);


--
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.reviews_id_seq', 4, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.roles_id_seq', 3, true);


--
-- Name: states_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.states_id_seq', 362, true);


--
-- Name: statuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.statuses_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: vats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: venenciame
--

SELECT pg_catalog.setval('public.vats_id_seq', 2, true);


--
-- Name: articles articles_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_pkey PRIMARY KEY (id);


--
-- Name: categories categories_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_label_key UNIQUE (label);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- Name: denominations denominations_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations
    ADD CONSTRAINT denominations_label_key UNIQUE (label);


--
-- Name: denominations denominations_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.denominations
    ADD CONSTRAINT denominations_pkey PRIMARY KEY (id);


--
-- Name: favorites favorites_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_pkey PRIMARY KEY (id);


--
-- Name: followers followers_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_pkey PRIMARY KEY (id);


--
-- Name: languages languages_code_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_code_key UNIQUE (code);


--
-- Name: languages languages_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_label_key UNIQUE (label);


--
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (id);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: partners partners_name_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_name_key UNIQUE (name);


--
-- Name: partners partners_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_pkey PRIMARY KEY (id);


--
-- Name: partners partners_user_id_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_user_id_key UNIQUE (user_id);


--
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- Name: reviews reviews_user_id_article_id_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_article_id_key UNIQUE (user_id, article_id);


--
-- Name: roles roles_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_label_key UNIQUE (label);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: states states_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_pkey PRIMARY KEY (id);


--
-- Name: statuses statuses_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses
    ADD CONSTRAINT statuses_label_key UNIQUE (label);


--
-- Name: statuses statuses_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.statuses
    ADD CONSTRAINT statuses_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: vats vats_label_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_label_key UNIQUE (label);


--
-- Name: vats vats_pkey; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_pkey PRIMARY KEY (id);


--
-- Name: vats vats_value_key; Type: CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.vats
    ADD CONSTRAINT vats_value_key UNIQUE (value);


--
-- Name: index_2; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_2 ON public.notifications USING btree (user_id);


--
-- Name: index_3; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_3 ON public.notifications USING btree (created_at);


--
-- Name: index_4; Type: INDEX; Schema: public; Owner: venenciame
--

CREATE INDEX index_4 ON public.notifications USING btree (seen);


--
-- Name: articles articles_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_denomination_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_denomination_id_fkey FOREIGN KEY (denomination_id) REFERENCES public.denominations(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_partner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_partner_id_fkey FOREIGN KEY (partner_id) REFERENCES public.partners(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: articles articles_vat_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_vat_id_fkey FOREIGN KEY (vat_id) REFERENCES public.vats(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: favorites favorites_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.articles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: favorites favorites_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: followers followers_partner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_partner_id_fkey FOREIGN KEY (partner_id) REFERENCES public.partners(id);


--
-- Name: followers followers_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.followers
    ADD CONSTRAINT followers_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: partners partners_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_country_id_fkey FOREIGN KEY (country_id) REFERENCES public.countries(id);


--
-- Name: partners partners_state_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_state_id_fkey FOREIGN KEY (state_id) REFERENCES public.states(id);


--
-- Name: partners partners_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id);


--
-- Name: partners partners_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.partners
    ADD CONSTRAINT partners_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: reviews reviews_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.articles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: reviews reviews_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: states states_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_country_id_fkey FOREIGN KEY (country_id) REFERENCES public.countries(id);


--
-- Name: users users_language_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_language_id_fkey FOREIGN KEY (language_id) REFERENCES public.languages(id);


--
-- Name: users users_rol_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_rol_id_fkey FOREIGN KEY (rol_id) REFERENCES public.roles(id);


--
-- Name: users users_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: venenciame
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.statuses(id);


--
-- PostgreSQL database dump complete
--
