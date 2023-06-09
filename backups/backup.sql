--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

-- Started on 2023-06-09 14:50:42

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

DROP DATABASE studentolx;
--
-- TOC entry 3365 (class 1262 OID 16398)
-- Name: studentolx; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE studentolx WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Polish_Poland.1250';


ALTER DATABASE studentolx OWNER TO postgres;

\connect studentolx

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 214 (class 1259 OID 16441)
-- Name: accounts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.accounts (
    accountid integer NOT NULL,
    userid integer NOT NULL,
    login character(100) NOT NULL,
    password character(50) NOT NULL,
    account_type integer NOT NULL,
    veryfied boolean NOT NULL
);


ALTER TABLE public.accounts OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16444)
-- Name: auction; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auction (
    auctionid integer NOT NULL,
    accountid integer NOT NULL,
    categoryid integer NOT NULL,
    title character(100),
    desctription text,
    used boolean,
    private boolean,
    date_start date,
    date_end date,
    selled boolean,
    buyerid integer
);


ALTER TABLE public.auction OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16449)
-- Name: category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category (
    categoryid integer NOT NULL,
    name integer NOT NULL,
    in_treee integer
);


ALTER TABLE public.category OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16452)
-- Name: file_to_auction; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.file_to_auction (
    fileid integer NOT NULL,
    auctionid integer NOT NULL,
    link character(200) NOT NULL
);


ALTER TABLE public.file_to_auction OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16455)
-- Name: message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message (
    id integer NOT NULL,
    mlid integer NOT NULL,
    date date DEFAULT now() NOT NULL,
    description text
);


ALTER TABLE public.message OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16461)
-- Name: message_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message_link (
    mlid integer NOT NULL,
    sellerid integer NOT NULL,
    buyerid integer NOT NULL,
    auctionid integer NOT NULL
);


ALTER TABLE public.message_link OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16464)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    userid integer NOT NULL,
    firstname character(50),
    latname character(150),
    email character(250),
    phone character(9),
    addres character(200),
    codezip character(6),
    city character(50),
    contury character(50)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 3353 (class 0 OID 16441)
-- Dependencies: 214
-- Data for Name: accounts; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3354 (class 0 OID 16444)
-- Dependencies: 215
-- Data for Name: auction; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3355 (class 0 OID 16449)
-- Dependencies: 216
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3356 (class 0 OID 16452)
-- Dependencies: 217
-- Data for Name: file_to_auction; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3357 (class 0 OID 16455)
-- Dependencies: 218
-- Data for Name: message; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3358 (class 0 OID 16461)
-- Dependencies: 219
-- Data for Name: message_link; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3359 (class 0 OID 16464)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3198 (class 2606 OID 16470)
-- Name: accounts accounts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accounts
    ADD CONSTRAINT accounts_pkey PRIMARY KEY (accountid);


--
-- TOC entry 3200 (class 2606 OID 16472)
-- Name: auction auction_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auction
    ADD CONSTRAINT auction_pkey PRIMARY KEY (auctionid);


--
-- TOC entry 3202 (class 2606 OID 16474)
-- Name: category category_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (categoryid);


--
-- TOC entry 3204 (class 2606 OID 16476)
-- Name: file_to_auction file_to_auction_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.file_to_auction
    ADD CONSTRAINT file_to_auction_pkey PRIMARY KEY (fileid);


--
-- TOC entry 3208 (class 2606 OID 16478)
-- Name: message_link message_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message_link
    ADD CONSTRAINT message_link_pkey PRIMARY KEY (mlid);


--
-- TOC entry 3206 (class 2606 OID 16480)
-- Name: message message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT message_pkey PRIMARY KEY (id);


--
-- TOC entry 3210 (class 2606 OID 16482)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


-- Completed on 2023-06-09 14:50:42

--
-- PostgreSQL database dump complete
--

