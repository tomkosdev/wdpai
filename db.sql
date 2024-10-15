--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4 (Debian 16.4-1.pgdg120+2)
-- Dumped by pg_dump version 16.4

-- Started on 2024-10-15 10:00:15 UTC

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
-- TOC entry 223 (class 1255 OID 32769)
-- Name: dislike_map(integer, integer); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.dislike_map(IN map_id integer, IN user_id integer)
    LANGUAGE sql
    AS $$SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;

SELECT * FROM public.maps WHERE id = map_id FOR UPDATE;

UPDATE public.maps SET likes=likes-1 WHERE id = map_id;
DELETE FROM public.user_map_likes WHERE id_map = map_id AND id_user = user_id;$$;


ALTER PROCEDURE public.dislike_map(IN map_id integer, IN user_id integer) OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 215 (class 1259 OID 16391)
-- Name: user_map_likes; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.user_map_likes (
    id_user integer NOT NULL,
    id_map integer NOT NULL
);


ALTER TABLE public.user_map_likes OWNER TO docker;

--
-- TOC entry 235 (class 1255 OID 32770)
-- Name: is_map_liked(integer, integer); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.is_map_liked(map_id integer, user_id integer) RETURNS integer
    LANGUAGE sql
    RETURN (SELECT 1 FROM public.user_map_likes WHERE ((user_map_likes.id_map = is_map_liked.map_id) AND (user_map_likes.id_user = is_map_liked.user_id)));


ALTER FUNCTION public.is_map_liked(map_id integer, user_id integer) OWNER TO docker;

--
-- TOC entry 236 (class 1255 OID 32771)
-- Name: like_map(integer, integer); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.like_map(IN map_id integer, IN user_id integer)
    LANGUAGE sql
    AS $$SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;

SELECT * FROM public.user_map_likes WHERE id_map = map_id FOR UPDATE;

UPDATE public.maps e SET likes=likes+1 WHERE e.id = map_id;
INSERT INTO public.user_map_likes (id_user, id_map) VALUES (user_id, map_id);

$$;


ALTER PROCEDURE public.like_map(IN map_id integer, IN user_id integer) OWNER TO docker;

--
-- TOC entry 216 (class 1259 OID 16395)
-- Name: user_credentials; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.user_credentials (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL
);


ALTER TABLE public.user_credentials OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16400)
-- Name: detailspk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.detailspk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detailspk OWNER TO docker;

--
-- TOC entry 3404 (class 0 OID 0)
-- Dependencies: 217
-- Name: detailspk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.detailspk OWNED BY public.user_credentials.id;


--
-- TOC entry 218 (class 1259 OID 16401)
-- Name: maps; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.maps (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255),
    date date,
    likes integer DEFAULT 0,
    image character varying(255),
    uploader character varying DEFAULT ''::character varying,
    pk3file character varying DEFAULT ''::character varying
);


ALTER TABLE public.maps OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16407)
-- Name: mapspk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.mapspk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.mapspk OWNER TO docker;

--
-- TOC entry 3405 (class 0 OID 0)
-- Dependencies: 219
-- Name: mapspk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.mapspk OWNED BY public.maps.id;


--
-- TOC entry 220 (class 1259 OID 16408)
-- Name: roles; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    role character varying(255) NOT NULL
);


ALTER TABLE public.roles OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 16411)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    role integer DEFAULT 2,
    credential integer NOT NULL,
    nickname character varying DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16418)
-- Name: userpk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.userpk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.userpk OWNER TO docker;

--
-- TOC entry 3406 (class 0 OID 0)
-- Dependencies: 222
-- Name: userpk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.userpk OWNED BY public.users.id;


--
-- TOC entry 3225 (class 2604 OID 16420)
-- Name: maps id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.maps ALTER COLUMN id SET DEFAULT nextval('public.mapspk'::regclass);


--
-- TOC entry 3224 (class 2604 OID 16419)
-- Name: user_credentials id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_credentials ALTER COLUMN id SET DEFAULT nextval('public.detailspk'::regclass);


--
-- TOC entry 3229 (class 2604 OID 16421)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.userpk'::regclass);


--
-- TOC entry 3394 (class 0 OID 16401)
-- Dependencies: 218
-- Data for Name: maps; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.maps (id, name, description, date, likes, image, uploader, pk3file) FROM stdin;
98	Venice	W:ET map	2024-10-14	0	Venice.jpg	ADMIN	Venice.pk3
99	Goldrush-gals	W:ET map	2024-10-14	0	goldrush-gals.jpg	ADMIN	goldrush-gals.pk3
96	Radar summer	W:ET map	2024-10-14	1	radar_summer.jpg	ADMIN	radar_summer.pk3
95	Caen	W:ET map	2024-10-14	0	caen.jpg	ADMIN	caen.pk3
94	Supply Depot	W:ET map	2024-10-14	1	supplydepot.jpg	ADMIN	supplydepot.pk3
97	Railgun	W:ET map	2024-10-14	0	railgun.jpg	ADMIN	railgun.pk3
100	Goldrush	W:ET map	2024-10-14	1	goldrush.jpg	ADMIN	goldrush.pk3
\.


--
-- TOC entry 3396 (class 0 OID 16408)
-- Dependencies: 220
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.roles (id, role) FROM stdin;
1	Admin
3	Guest
4	Moderator
5	Mapper
6	Modder
2	User
\.


--
-- TOC entry 3392 (class 0 OID 16395)
-- Dependencies: 216
-- Data for Name: user_credentials; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.user_credentials (id, email, password) FROM stdin;
2	guest@guest.pl	084e0343a0486ff05530df6c705c8bb4
1	admin@admin.pl	21232f297a57a5a743894a0e4a801fc3
10	tomek@tomek.pl	d0d41f1a3cc3f67dcd74694de9fef1b0
\.


--
-- TOC entry 3391 (class 0 OID 16391)
-- Dependencies: 215
-- Data for Name: user_map_likes; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.user_map_likes (id_user, id_map) FROM stdin;
13	100
13	96
3	94
\.


--
-- TOC entry 3397 (class 0 OID 16411)
-- Dependencies: 221
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users (id, role, credential, nickname) FROM stdin;
3	1	1	ADMIN
4	3	2	GUEST
13	2	10	TomekKromek
\.


--
-- TOC entry 3407 (class 0 OID 0)
-- Dependencies: 217
-- Name: detailspk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.detailspk', 13, true);


--
-- TOC entry 3408 (class 0 OID 0)
-- Dependencies: 219
-- Name: mapspk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.mapspk', 100, true);


--
-- TOC entry 3409 (class 0 OID 0)
-- Dependencies: 222
-- Name: userpk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.userpk', 16, true);


--
-- TOC entry 3235 (class 2606 OID 16425)
-- Name: user_credentials details_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_credentials
    ADD CONSTRAINT details_pkey PRIMARY KEY (id);


--
-- TOC entry 3237 (class 2606 OID 16427)
-- Name: maps maps_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.maps
    ADD CONSTRAINT maps_pkey PRIMARY KEY (id);


--
-- TOC entry 3239 (class 2606 OID 16429)
-- Name: roles permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- TOC entry 3233 (class 2606 OID 16423)
-- Name: user_map_likes user_map_likes_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_map_likes
    ADD CONSTRAINT user_map_likes_pkey PRIMARY KEY (id_user, id_map);


--
-- TOC entry 3241 (class 2606 OID 40962)
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk UNIQUE (credential);


--
-- TOC entry 3243 (class 2606 OID 16431)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3246 (class 2606 OID 16432)
-- Name: users FK 1; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "FK 1" FOREIGN KEY (role) REFERENCES public.roles(id) NOT VALID;


--
-- TOC entry 3244 (class 2606 OID 16437)
-- Name: user_map_likes FK 1; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_map_likes
    ADD CONSTRAINT "FK 1" FOREIGN KEY (id_user) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3245 (class 2606 OID 16442)
-- Name: user_map_likes FK 2; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_map_likes
    ADD CONSTRAINT "FK 2" FOREIGN KEY (id_map) REFERENCES public.maps(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3247 (class 2606 OID 16447)
-- Name: users FK 2; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "FK 2" FOREIGN KEY (credential) REFERENCES public.user_credentials(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


-- Completed on 2024-10-15 10:00:15 UTC

--
-- PostgreSQL database dump complete
--

