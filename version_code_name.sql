--
-- PostgreSQL database dump
--

-- Dumped from database version 13.1
-- Dumped by pg_dump version 13.1

-- Started on 2020-11-23 16:32:17

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
-- TOC entry 200 (class 1259 OID 16403)
-- Name: version_code_name; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.version_code_name (
    id bigint NOT NULL,
    version_code bigint NOT NULL,
    version_name text NOT NULL,
    password text
);


ALTER TABLE public.version_code_name OWNER TO postgres;

--
-- TOC entry 2980 (class 0 OID 16403)
-- Dependencies: 200
-- Data for Name: version_code_name; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.version_code_name (id, version_code, version_name, password) FROM stdin;
1	1	1.0	$2y$10$zSRtb2w9gakJ6OdnIoJCMuLJQkdeAXBRxr4YSjqIbu8ThStahKkg6
\.


--
-- TOC entry 2849 (class 2606 OID 16410)
-- Name: version_code_name version_code_name_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.version_code_name
    ADD CONSTRAINT version_code_name_pkey PRIMARY KEY (id);


-- Completed on 2020-11-23 16:32:17

--
-- PostgreSQL database dump complete
--

