--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2
-- Dumped by pg_dump version 17.2

-- Started on 2025-06-07 09:00:48

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 16643)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 4973 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 219 (class 1259 OID 16524)
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admins (
    admins_id integer NOT NULL,
    username character varying(50) NOT NULL,
    password text NOT NULL
);


ALTER TABLE public.admins OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16523)
-- Name: admins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admins_id_seq OWNER TO postgres;

--
-- TOC entry 4974 (class 0 OID 0)
-- Dependencies: 218
-- Name: admins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admins_id_seq OWNED BY public.admins.admins_id;


--
-- TOC entry 221 (class 1259 OID 16535)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    clients_id integer NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL,
    username character varying(100)
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16534)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- TOC entry 4975 (class 0 OID 0)
-- Dependencies: 220
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.clients_id;


--
-- TOC entry 223 (class 1259 OID 16546)
-- Name: displays; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.displays (
    display_id integer NOT NULL,
    name character varying(100) NOT NULL,
    description text,
    price numeric(6,2) NOT NULL,
    stock integer DEFAULT 0 NOT NULL,
    image_url text
);


ALTER TABLE public.displays OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16545)
-- Name: displays_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.displays_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.displays_id_seq OWNER TO postgres;

--
-- TOC entry 4976 (class 0 OID 0)
-- Dependencies: 222
-- Name: displays_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.displays_id_seq OWNED BY public.displays.display_id;


--
-- TOC entry 225 (class 1259 OID 16607)
-- Name: purchases; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.purchases (
    purchases_id integer NOT NULL,
    client_id integer,
    purchase_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    display_id integer NOT NULL,
    quantity integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.purchases OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16606)
-- Name: purchases_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.purchases_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.purchases_id_seq OWNER TO postgres;

--
-- TOC entry 4977 (class 0 OID 0)
-- Dependencies: 224
-- Name: purchases_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.purchases_id_seq OWNED BY public.purchases.purchases_id;


--
-- TOC entry 4794 (class 2604 OID 16527)
-- Name: admins admins_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins ALTER COLUMN admins_id SET DEFAULT nextval('public.admins_id_seq'::regclass);


--
-- TOC entry 4795 (class 2604 OID 16538)
-- Name: clients clients_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN clients_id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- TOC entry 4796 (class 2604 OID 16549)
-- Name: displays display_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.displays ALTER COLUMN display_id SET DEFAULT nextval('public.displays_id_seq'::regclass);


--
-- TOC entry 4798 (class 2604 OID 16610)
-- Name: purchases purchases_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.purchases ALTER COLUMN purchases_id SET DEFAULT nextval('public.purchases_id_seq'::regclass);


--
-- TOC entry 4961 (class 0 OID 16524)
-- Dependencies: 219
-- Data for Name: admins; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admins (admins_id, username, password) FROM stdin;
1	Admin	$2a$06$i59tBvW9TyHZcvBt24Kin.5o7oCNajGSrLaiIyimtfDV9vDgQUYai
\.


--
-- TOC entry 4963 (class 0 OID 16535)
-- Dependencies: 221
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (clients_id, email, password, username) FROM stdin;
4	ophelie@gmail.com	$2y$10$l5B4qy/LsyUqqCSykTBn/OoyFsaPeZJ7gBeaTdLLCH53pXXyTBlRq	Ophelie
6	noah@gmail.com	$2y$10$zt1..3gKEAYf9we1icI3OOnWhlyLbDoz8f7nGEZaaGCrPmnfRUBaW	Noah
\.


--
-- TOC entry 4965 (class 0 OID 16546)
-- Dependencies: 223
-- Data for Name: displays; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.displays (display_id, name, description, price, stock, image_url) FROM stdin;
2	White Flare	Display Japonais White Flare	98.90	54	assets/images/sv11W.webp
1	Black Bolt	Display Japonais Black Boltn	98.90	56	assets/images/sv11B.webp
9	Snow Hazard	Display Japonais Snow Hazard	59.90	60	assets/images/sv2P.jpg
10	Clay Burst	Display Japonais Clay Burst	59.90	60	assets/images/sv2D.jpg
11	Triplet Beat	Display Japonais Triplet Beat	59.90	60	assets/images/sv1a.jpg
3	The Glory of Team Rocket	Display Japonais The Glory of Team Rocket	108.90	52	assets/images/sv10.webp
8	Paradise Dragona	Display Japonais Paradise Dragona	59.90	58	assets/images/sv7a.jpg
4	Pokemon 151	Display Japonais Pokemon 151	119.80	44	assets/images/sv2a.webp
6	Battle Partners	Display Japonais Battle Partners	79.90	38	assets/images/sv9.jpg
\.


--
-- TOC entry 4967 (class 0 OID 16607)
-- Dependencies: 225
-- Data for Name: purchases; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.purchases (purchases_id, client_id, purchase_date, display_id, quantity) FROM stdin;
\.


--
-- TOC entry 4978 (class 0 OID 0)
-- Dependencies: 218
-- Name: admins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admins_id_seq', 2, true);


--
-- TOC entry 4979 (class 0 OID 0)
-- Dependencies: 220
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 6, true);


--
-- TOC entry 4980 (class 0 OID 0)
-- Dependencies: 222
-- Name: displays_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.displays_id_seq', 11, true);


--
-- TOC entry 4981 (class 0 OID 0)
-- Dependencies: 224
-- Name: purchases_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.purchases_id_seq', 1, false);


--
-- TOC entry 4802 (class 2606 OID 16531)
-- Name: admins admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (admins_id);


--
-- TOC entry 4804 (class 2606 OID 16533)
-- Name: admins admins_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_username_key UNIQUE (username);


--
-- TOC entry 4806 (class 2606 OID 16544)
-- Name: clients clients_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_email_key UNIQUE (email);


--
-- TOC entry 4808 (class 2606 OID 16542)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (clients_id);


--
-- TOC entry 4810 (class 2606 OID 16554)
-- Name: displays displays_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.displays
    ADD CONSTRAINT displays_pkey PRIMARY KEY (display_id);


--
-- TOC entry 4812 (class 2606 OID 16613)
-- Name: purchases purchases_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.purchases
    ADD CONSTRAINT purchases_pkey PRIMARY KEY (purchases_id);


--
-- TOC entry 4813 (class 2606 OID 16638)
-- Name: purchases fk_display; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.purchases
    ADD CONSTRAINT fk_display FOREIGN KEY (display_id) REFERENCES public.displays(display_id);


--
-- TOC entry 4814 (class 2606 OID 16614)
-- Name: purchases purchases_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.purchases
    ADD CONSTRAINT purchases_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.clients(clients_id);


-- Completed on 2025-06-07 09:00:48

--
-- PostgreSQL database dump complete
--

