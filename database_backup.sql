--
-- PostgreSQL database dump
--

\restrict FyIcQabJ2RF4piAc9Up7f3kh9zzewcg3dO0lwHtbfCu7u0IbFF0FpddtgcpQL6V

-- Dumped from database version 16.2 (Postgres.app)
-- Dumped by pg_dump version 16.11 (Homebrew)

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
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    parent_id bigint,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    website character varying(255),
    logo_id bigint,
    tags json,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- Name: company_histories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_histories (
    id bigint NOT NULL,
    year integer NOT NULL,
    image_id bigint,
    is_active boolean DEFAULT true NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.company_histories OWNER TO postgres;

--
-- Name: COLUMN company_histories.year; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.company_histories.year IS 'Year of the milestone';


--
-- Name: company_histories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.company_histories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.company_histories_id_seq OWNER TO postgres;

--
-- Name: company_histories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.company_histories_id_seq OWNED BY public.company_histories.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: media; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.media (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    mime_type character varying(255) NOT NULL,
    path character varying(255) NOT NULL,
    size integer NOT NULL,
    disk character varying(255) DEFAULT 'public'::character varying NOT NULL,
    metadata json,
    uploaded_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.media OWNER TO postgres;

--
-- Name: media_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.media_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.media_id_seq OWNER TO postgres;

--
-- Name: media_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.media_id_seq OWNED BY public.media.id;


--
-- Name: menu_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_items (
    id bigint NOT NULL,
    menu_id bigint NOT NULL,
    parent_id bigint,
    type character varying(255) DEFAULT 'custom'::character varying NOT NULL,
    linkable_id bigint,
    linkable_type character varying(255),
    url character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    target character varying(255) DEFAULT '_self'::character varying NOT NULL,
    icon character varying(255),
    css_class character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    navigation_menu_slug character varying(255)
);


ALTER TABLE public.menu_items OWNER TO postgres;

--
-- Name: COLUMN menu_items.navigation_menu_slug; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.menu_items.navigation_menu_slug IS 'Navigation menu to display when this top menu item is active';


--
-- Name: menu_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_items_id_seq OWNER TO postgres;

--
-- Name: menu_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_items_id_seq OWNED BY public.menu_items.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    location character varying(255) NOT NULL,
    description character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: page_sections; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.page_sections (
    id bigint NOT NULL,
    page_id bigint NOT NULL,
    type character varying(255) DEFAULT 'tab'::character varying NOT NULL,
    icon character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.page_sections OWNER TO postgres;

--
-- Name: page_sections_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.page_sections_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.page_sections_id_seq OWNER TO postgres;

--
-- Name: page_sections_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.page_sections_id_seq OWNED BY public.page_sections.id;


--
-- Name: pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pages (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    content text NOT NULL,
    template character varying(255) DEFAULT 'default'::character varying NOT NULL,
    author_id bigint NOT NULL,
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    published_at timestamp(0) without time zone,
    meta_tags json,
    meta_title character varying(255),
    meta_description text,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    header_image_id bigint,
    hide_title boolean DEFAULT false NOT NULL,
    CONSTRAINT pages_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'published'::character varying, 'archived'::character varying])::text[])))
);


ALTER TABLE public.pages OWNER TO postgres;

--
-- Name: pages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pages_id_seq OWNER TO postgres;

--
-- Name: pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pages_id_seq OWNED BY public.pages.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: permission_role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permission_role (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.permission_role OWNER TO postgres;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: posts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.posts (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    excerpt text,
    content text NOT NULL,
    category_id bigint,
    author_id bigint NOT NULL,
    featured_image_id bigint,
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    published_at timestamp(0) without time zone,
    meta_tags json,
    meta_title character varying(255),
    meta_description text,
    views integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT posts_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'published'::character varying, 'archived'::character varying])::text[])))
);


ALTER TABLE public.posts OWNER TO postgres;

--
-- Name: posts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.posts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.posts_id_seq OWNER TO postgres;

--
-- Name: posts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.posts_id_seq OWNED BY public.posts.id;


--
-- Name: role_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_user (
    role_id bigint NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.role_user OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: service_sections; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.service_sections (
    id bigint NOT NULL,
    service_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    content text,
    type character varying(255) DEFAULT 'tab'::character varying NOT NULL,
    icon character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT service_sections_type_check CHECK (((type)::text = ANY ((ARRAY['tab'::character varying, 'accordion'::character varying, 'content'::character varying])::text[])))
);


ALTER TABLE public.service_sections OWNER TO postgres;

--
-- Name: service_sections_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.service_sections_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.service_sections_id_seq OWNER TO postgres;

--
-- Name: service_sections_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.service_sections_id_seq OWNED BY public.service_sections.id;


--
-- Name: service_widgets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.service_widgets (
    id bigint NOT NULL,
    service_id bigint NOT NULL,
    widget_id bigint NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.service_widgets OWNER TO postgres;

--
-- Name: service_widgets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.service_widgets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.service_widgets_id_seq OWNER TO postgres;

--
-- Name: service_widgets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.service_widgets_id_seq OWNED BY public.service_widgets.id;


--
-- Name: services; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.services (
    id bigint NOT NULL,
    slug character varying(255) NOT NULL,
    icon character varying(255),
    featured_image_id bigint,
    is_active boolean DEFAULT true NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.services OWNER TO postgres;

--
-- Name: services_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.services_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.services_id_seq OWNER TO postgres;

--
-- Name: services_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.services_id_seq OWNED BY public.services.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    id bigint NOT NULL,
    key character varying(255) NOT NULL,
    value text,
    type character varying(255) DEFAULT 'text'::character varying NOT NULL,
    "group" character varying(255) DEFAULT 'general'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.settings_id_seq OWNER TO postgres;

--
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- Name: sliders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sliders (
    id bigint NOT NULL,
    image_id bigint,
    button_text character varying(255),
    button_url character varying(255),
    button_target character varying(255) DEFAULT '_self'::character varying NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.sliders OWNER TO postgres;

--
-- Name: sliders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sliders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sliders_id_seq OWNER TO postgres;

--
-- Name: sliders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sliders_id_seq OWNED BY public.sliders.id;


--
-- Name: team_members; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.team_members (
    id bigint NOT NULL,
    slug character varying(255) NOT NULL,
    email character varying(255),
    phone character varying(255),
    facebook character varying(255),
    twitter character varying(255),
    linkedin character varying(255),
    photo_id bigint,
    is_active boolean DEFAULT true NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.team_members OWNER TO postgres;

--
-- Name: team_members_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.team_members_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.team_members_id_seq OWNER TO postgres;

--
-- Name: team_members_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.team_members_id_seq OWNED BY public.team_members.id;


--
-- Name: testimonials; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.testimonials (
    id bigint NOT NULL,
    client_name character varying(255) NOT NULL,
    client_position character varying(255),
    client_company character varying(255),
    client_photo_id bigint,
    content text NOT NULL,
    rating integer DEFAULT 5 NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.testimonials OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.testimonials_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.testimonials_id_seq OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.testimonials_id_seq OWNED BY public.testimonials.id;


--
-- Name: translations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.translations (
    id bigint NOT NULL,
    translatable_type character varying(255) NOT NULL,
    translatable_id bigint NOT NULL,
    locale character varying(10) NOT NULL,
    field character varying(255) NOT NULL,
    value text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.translations OWNER TO postgres;

--
-- Name: translations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.translations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.translations_id_seq OWNER TO postgres;

--
-- Name: translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.translations_id_seq OWNED BY public.translations.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: widgets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.widgets (
    id bigint NOT NULL,
    key character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    content json,
    area character varying(255) DEFAULT 'sidebar'::character varying NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.widgets OWNER TO postgres;

--
-- Name: widgets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.widgets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.widgets_id_seq OWNER TO postgres;

--
-- Name: widgets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.widgets_id_seq OWNED BY public.widgets.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- Name: company_histories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_histories ALTER COLUMN id SET DEFAULT nextval('public.company_histories_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: media id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media ALTER COLUMN id SET DEFAULT nextval('public.media_id_seq'::regclass);


--
-- Name: menu_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_items ALTER COLUMN id SET DEFAULT nextval('public.menu_items_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: page_sections id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_sections ALTER COLUMN id SET DEFAULT nextval('public.page_sections_id_seq'::regclass);


--
-- Name: pages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages ALTER COLUMN id SET DEFAULT nextval('public.pages_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: posts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts ALTER COLUMN id SET DEFAULT nextval('public.posts_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: service_sections id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_sections ALTER COLUMN id SET DEFAULT nextval('public.service_sections_id_seq'::regclass);


--
-- Name: service_widgets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_widgets ALTER COLUMN id SET DEFAULT nextval('public.service_widgets_id_seq'::regclass);


--
-- Name: services id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.services ALTER COLUMN id SET DEFAULT nextval('public.services_id_seq'::regclass);


--
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- Name: sliders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sliders ALTER COLUMN id SET DEFAULT nextval('public.sliders_id_seq'::regclass);


--
-- Name: team_members id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_members ALTER COLUMN id SET DEFAULT nextval('public.team_members_id_seq'::regclass);


--
-- Name: testimonials id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials ALTER COLUMN id SET DEFAULT nextval('public.testimonials_id_seq'::regclass);


--
-- Name: translations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations ALTER COLUMN id SET DEFAULT nextval('public.translations_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: widgets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.widgets ALTER COLUMN id SET DEFAULT nextval('public.widgets_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
intax-s-counsel-cache-setting_general_enabled_locales	s:8:"en,mn,zh";	1768118344
intax-s-counsel-cache-setting_general_default_locale	s:2:"zh";	1768118344
intax-s-counsel-cache-setting_general_site_name	s:18:"InTaxS Councel LLC";	1768118344
intax-s-counsel-cache-setting_general_site_description	s:778:"Манай компани нь гадаад хөрөнгө оруулагчид МУ-д хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах, компани байгуулагдаж эхлэхээс эхлэн үйл ажиллагааг жигдэрүүлэх, цааш тасралтгүй амжилттай үйл ажиллагааг явуулах бүхий л үйл явцыг зохион байгуулах, санхүү татварын бүх төрлийн тайлангууд бэлтгэх, холбогдох байгууллагуудад тайлагнах, зөвлөх үйлчилгээг үзүүлдэг юм.";	1768118344
intax-s-counsel-cache-setting_general_primary_color	s:7:"#d40c19";	1768118344
intax-s-counsel-cache-setting_general_logo	s:1:"1";	1768118344
intax-s-counsel-cache-setting_general_favicon	s:1:"3";	1768118344
intax-s-counsel-cache-setting_contact_email	s:24:"saranchimeg-ceo@intax.mn";	1768118344
intax-s-counsel-cache-setting_contact_phone	s:20:"7721-8818, 9922-2288";	1768118344
intax-s-counsel-cache-setting_contact_address	s:62:"Khan-Uul District, 17th Khoroo, Zaisan Star Residence, 56-2-92";	1768118344
intax-s-counsel-cache-setting_social_facebook	s:54:"https://www.facebook.com/profile.php?id=61563460747992";	1768118344
intax-s-counsel-cache-setting_footer_copyright	s:26:"© 2025 InTaxS Councel LLC";	1768118344
intax-s-counsel-cache-setting_footer_about_text	s:778:"Манай компани нь гадаад хөрөнгө оруулагчид МУ-д хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах, компани байгуулагдаж эхлэхээс эхлэн үйл ажиллагааг жигдэрүүлэх, цааш тасралтгүй амжилттай үйл ажиллагааг явуулах бүхий л үйл явцыг зохион байгуулах, санхүү татварын бүх төрлийн тайлангууд бэлтгэх, холбогдох байгууллагуудад тайлагнах, зөвлөх үйлчилгээг үзүүлдэг юм.";	1768118344
intax-s-counsel-cache-setting_social_twitter	N;	1768119442
intax-s-counsel-cache-setting_social_instagram	N;	1768119442
intax-s-counsel-cache-setting_social_linkedin	N;	1768119442
intax-s-counsel-cache-setting_social_youtube	N;	1768119442
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, slug, description, parent_id, "order", is_active, created_at, updated_at) FROM stdin;
1	News	news		\N	0	t	2025-12-15 13:04:33	2025-12-15 13:04:33
\.


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, name, slug, description, website, logo_id, tags, "order", is_active, created_at, updated_at) FROM stdin;
2	E-Shop Ltd	e-shop-ltd	Online retail platform	https://eshop.example.com	\N	["E-Commerce","Retail"]	2	t	2025-12-15 10:29:25	2025-12-15 10:29:25
3	Finance Plus	finance-plus	Financial services company	https://financeplus.example.com	\N	["Finance","Banking","Enterprise"]	3	t	2025-12-15 10:29:25	2025-12-15 10:29:25
4	Health Care Solutions	health-care-solutions	Healthcare technology provider	https://healthcare.example.com	\N	["Healthcare","Technology"]	4	t	2025-12-15 10:29:25	2025-12-15 10:29:25
5	Edu Platform	edu-platform	Online education platform	https://eduplatform.example.com	\N	["Education","SaaS"]	5	t	2025-12-15 10:29:25	2025-12-15 10:29:25
6	Food Delivery Co	food-delivery-co	Food delivery service	https://fooddelivery.example.com	\N	["Food","E-Commerce","Delivery"]	6	t	2025-12-15 10:29:25	2025-12-15 10:29:25
1	Tech Corpsadasd	tech-corp	Leading technology solutions provider	https://techcorp.example.com	19	["Technology","SaaS","Enterprise"]	1	t	2025-12-15 10:29:25	2025-12-15 20:44:49
\.


--
-- Data for Name: company_histories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.company_histories (id, year, image_id, is_active, "order", created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: media; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.media (id, name, file_name, mime_type, path, size, disk, metadata, uploaded_by, created_at, updated_at) FROM stdin;
1	intax-logo	1765765871_intax-logo.png	image/png	uploads/1765765871_intax-logo.png	19795	public	{"original_name":"intax-logo.png","extension":"png"}	1	2025-12-15 10:31:11	2025-12-15 10:31:11
2	android-chrome-512x512	1765769205_android-chrome-512x512.png	image/png	uploads/1765769205_android-chrome-512x512.png	117038	public	{"original_name":"android-chrome-512x512.png","extension":"png"}	1	2025-12-15 11:26:45	2025-12-15 11:26:45
3	intax-logo-fav	1765769276_intax-logo-fav.png	image/png	uploads/1765769276_intax-logo-fav.png	9155	public	{"original_name":"intax-logo-fav.png","extension":"png"}	1	2025-12-15 11:27:56	2025-12-15 11:27:56
4	Screenshot 2025-12-15 at 11.49.09	1765770584_Screenshot_2025-12-15_at_11.49.09.png	image/png	uploads/1765770584_Screenshot_2025-12-15_at_11.49.09.png	1344273	public	{"original_name":"Screenshot 2025-12-15 at 11.49.09.png","extension":"png"}	1	2025-12-15 11:49:44	2025-12-15 11:49:44
5	intax-header	1765772726_intax-header.png	image/png	uploads/1765772726_intax-header.png	510431	public	{"original_name":"intax-header.png","extension":"png"}	1	2025-12-15 12:25:26	2025-12-15 12:25:26
6	slider-1	1765775115_slider-1.jpg	image/jpeg	uploads/1765775115_slider-1.jpg	387663	public	{"original_name":"slider-1.jpg","extension":"jpg"}	1	2025-12-15 13:05:15	2025-12-15 13:05:15
7	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765786305_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765786305_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 16:11:45	2025-12-15 16:11:45
8	Microsoft-Logo-square1	1765786348_Microsoft-Logo-square1.jpg	image/jpeg	uploads/1765786348_Microsoft-Logo-square1.jpg	15541	public	{"original_name":"Microsoft-Logo-square1.jpg","extension":"jpg"}	1	2025-12-15 16:12:28	2025-12-15 16:12:28
9	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765792078_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765792078_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 17:47:59	2025-12-15 17:47:59
10	693f7b5851d7b	1765794015_693f7b5851d7b.jpeg	image/jpeg	uploads/1765794015_693f7b5851d7b.jpeg	74564	public	{"original_name":"693f7b5851d7b.jpeg","extension":"jpeg"}	1	2025-12-15 18:20:15	2025-12-15 18:20:15
11	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765794119_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765794119_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 18:21:59	2025-12-15 18:21:59
12	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765794148_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765794148_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 18:22:28	2025-12-15 18:22:28
13	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765794173_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765794173_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 18:22:53	2025-12-15 18:22:53
14	ChatGPT Image Dec 15, 2025, 12_05_35 PM	1765794196_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	image/png	uploads/1765794196_ChatGPT_Image_Dec_15,_2025,_12_05_35_PM.png	1766704	public	{"original_name":"ChatGPT Image Dec 15, 2025, 12_05_35 PM.png","extension":"png"}	1	2025-12-15 18:23:17	2025-12-15 18:23:17
15	intax logo	1765795011_intax_logo.jpg	image/jpeg	uploads/1765795011_intax_logo.jpg	152376	public	{"original_name":"intax logo.jpg","extension":"jpg"}	1	2025-12-15 18:36:51	2025-12-15 18:36:51
16	intax-logo	1765795029_intax-logo.png	image/png	uploads/1765795029_intax-logo.png	19795	public	{"original_name":"intax-logo.png","extension":"png"}	1	2025-12-15 18:37:10	2025-12-15 18:37:10
17	law-firm-03	1765796810_law-firm-03.jpg	image/jpeg	uploads/1765796810_law-firm-03.jpg	132310	public	{"original_name":"law-firm-03.jpg","extension":"jpg"}	1	2025-12-15 19:06:50	2025-12-15 19:06:50
18	accounting	1765796859_accounting.jpg	image/jpeg	uploads/1765796859_accounting.jpg	225325	public	{"original_name":"accounting.jpg","extension":"jpg"}	1	2025-12-15 19:07:39	2025-12-15 19:07:39
19	intax-logo-fav	1765802688_intax-logo-fav.png	image/png	uploads/1765802688_intax-logo-fav.png	9155	public	{"original_name":"intax-logo-fav.png","extension":"png"}	1	2025-12-15 20:44:48	2025-12-15 20:44:48
\.


--
-- Data for Name: menu_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_items (id, menu_id, parent_id, type, linkable_id, linkable_type, url, "order", target, icon, css_class, is_active, created_at, updated_at, navigation_menu_slug) FROM stdin;
1	1	\N	custom	\N	\N	/{locale}/	0	_self	🏠	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
2	1	\N	custom	\N	\N	/{locale}/about	1	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
3	1	\N	custom	\N	\N	/{locale}/services	2	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
4	1	\N	custom	\N	\N	/{locale}/posts	3	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
5	1	\N	custom	\N	\N	/{locale}/contact	4	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
6	2	\N	custom	\N	\N	/{locale}/	0	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
7	2	\N	custom	\N	\N	/{locale}/posts	1	_self	\N	\N	t	2025-12-15 10:28:30	2025-12-15 10:28:30	\N
9	3	\N	external	\N	\N	dvdfgdfb	0	_blank	\N	\N	t	2025-12-15 20:14:20	2025-12-15 20:14:20	\N
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, name, location, description, is_active, created_at, updated_at) FROM stdin;
1	Primary Menu	primary	Main navigation menu in header	t	2025-12-15 10:28:30	2025-12-15 10:28:30
2	Footer Menu	footer	Quick links in footer	t	2025-12-15 10:28:30	2025-12-15 10:28:30
3	Quick Links	quicklinks	\N	t	2025-12-15 20:13:47	2025-12-15 20:17:25
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_01_20_000001_create_menus_table	1
5	2025_01_20_000002_create_menu_items_table	1
6	2025_10_07_062230_create_categories_table	1
7	2025_10_07_062231_create_media_table	1
8	2025_10_07_062231_create_pages_table	1
9	2025_10_07_062231_create_permissions_table	1
10	2025_10_07_062231_create_roles_table	1
11	2025_10_07_062232_create_posts_table	1
12	2025_10_07_062407_create_permission_role_table	1
13	2025_10_07_062407_create_role_user_table	1
14	2025_10_07_064316_create_translations_table	1
15	2025_10_20_080600_create_personal_access_tokens_table	1
16	2025_10_21_103456_create_services_table	1
17	2025_10_21_162218_create_team_members_table	1
18	2025_10_21_171905_create_sliders_table	1
19	2025_10_21_224522_create_page_sections_table	1
20	2025_10_22_000048_create_settings_table	1
21	2025_10_22_103317_create_clients_table	1
22	2025_10_22_130345_create_testimonials_table	1
23	2025_10_24_110842_add_navigation_menu_slug_to_menu_items_table	1
24	2025_10_24_202716_create_company_histories_table	1
25	2025_11_03_114328_create_widgets_table	1
26	2025_11_03_225004_add_header_image_to_pages_table	1
27	2025_11_03_232415_add_hide_title_to_pages_table	1
28	2025_11_06_124205_create_service_sections_table	1
29	2025_11_06_124312_create_service_widgets_table	1
30	2025_11_06_125347_add_deleted_at_to_services_table	1
31	2025_11_06_135556_update_service_sections_type_constraint	1
\.


--
-- Data for Name: page_sections; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.page_sections (id, page_id, type, icon, "order", is_active, created_at, updated_at) FROM stdin;
2	1	tab	\N	0	t	2025-12-15 19:25:15	2025-12-15 19:25:15
\.


--
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pages (id, title, slug, content, template, author_id, status, published_at, meta_tags, meta_title, meta_description, "order", created_at, updated_at, deleted_at, header_image_id, hide_title) FROM stdin;
1	About us	about	<p><img src="/storage/uploads/1765795029_intax-logo.png" style="display: block; margin-left: auto; margin-right: auto;"></p><p>Intax S Counsel LLC is a professional advisory firm providing <strong>comprehensive tax, financial, and legal consulting services</strong> to foreign investors seeking to successfully establish and expand their businesses in Mongolia. By integrating international business practices with Mongolia’s legal and regulatory framework, we deliver practical, clear, and actionable solutions tailored to investors’ needs.</p><p>Our company works closely with clients throughout every stage of their business journey — from initial company formation to operational stabilization and sustainable growth. This includes introducing Mongolia’s tax, financial, and legal environment, assisting with proper investment planning, efficient use of capital, and providing guidance to mitigate potential risks.</p><p>In addition to preparing all types of financial and tax reports and submitting them to relevant government authorities in compliance with applicable laws, we provide ongoing accounting and advisory services related to daily business operations. Through these services, we help ensure that our clients’ businesses operate transparently, sustainably, and in full compliance with Mongolian regulations.</p><p>Our team places strong emphasis on ensuring that foreign investors’ capital is utilized <strong>legally, transparently, and efficiently</strong>, protecting businesses from fraud, mismanagement, and legal risks, and supporting their long-term success in Mongolia. Furthermore, by professionally managing the tax and financial reporting of foreign-invested companies, we aim to contribute to the proper formation of tax revenues and make a tangible contribution to Mongolia’s economic development.</p><p>Guided by professional ethics, transparency, and accountability, we strive to build long-term, value-driven partnerships tailored to each client’s specific needs. Intax S Counsel LLC is a competent and responsible team committed to serving as a <strong>trusted bridge between foreign investors and Mongolia’s business environment</strong>, fostering stable and mutually beneficial cooperation.</p>	full-width	1	published	2025-12-10 09:40:00	\N			0	2025-12-15 17:40:49	2025-12-15 19:25:15	\N	\N	f
2	Манай үйлчилгээ	services	<p></p><p style="text-align: justify;"><img src="https://www.intax.test/storage/uploads/1765796859_accounting.jpg" width="483" height="286" style="float: right; margin-left: 1rem; margin-bottom: 0.5rem;">Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм. Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.<br><br>Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.</p>	full-width	1	published	2025-12-09 18:54:00	\N			0	2025-12-15 18:54:39	2025-12-15 20:07:03	\N	\N	f
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permission_role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permission_role (permission_id, role_id) FROM stdin;
1	1
2	1
3	1
4	1
5	1
6	1
7	1
8	1
9	1
10	1
11	1
12	1
13	1
14	1
1	2
2	2
3	2
4	2
5	2
6	2
7	2
8	2
9	2
10	2
11	2
12	2
14	2
1	3
2	3
3	3
4	3
5	3
6	3
7	3
8	3
9	3
10	3
11	3
1	4
2	4
3	4
5	4
6	4
7	4
9	4
10	4
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, slug, description, created_at, updated_at) FROM stdin;
1	View Posts	view-posts	Can view posts	2025-12-15 10:28:29	2025-12-15 10:28:29
2	Create Posts	create-posts	Can create new posts	2025-12-15 10:28:29	2025-12-15 10:28:29
3	Edit Posts	edit-posts	Can edit posts	2025-12-15 10:28:29	2025-12-15 10:28:29
4	Delete Posts	delete-posts	Can delete posts	2025-12-15 10:28:29	2025-12-15 10:28:29
5	View Pages	view-pages	Can view pages	2025-12-15 10:28:29	2025-12-15 10:28:29
6	Create Pages	create-pages	Can create new pages	2025-12-15 10:28:29	2025-12-15 10:28:29
7	Edit Pages	edit-pages	Can edit pages	2025-12-15 10:28:29	2025-12-15 10:28:29
8	Delete Pages	delete-pages	Can delete pages	2025-12-15 10:28:29	2025-12-15 10:28:29
9	View Media	view-media	Can view media library	2025-12-15 10:28:29	2025-12-15 10:28:29
10	Upload Media	upload-media	Can upload files	2025-12-15 10:28:29	2025-12-15 10:28:29
11	Delete Media	delete-media	Can delete media	2025-12-15 10:28:29	2025-12-15 10:28:29
12	Manage Users	manage-users	Can manage users	2025-12-15 10:28:29	2025-12-15 10:28:29
13	Manage Roles	manage-roles	Can manage roles	2025-12-15 10:28:29	2025-12-15 10:28:29
14	Manage Settings	manage-settings	Can manage site settings	2025-12-15 10:28:29	2025-12-15 10:28:29
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: posts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.posts (id, title, slug, excerpt, content, category_id, author_id, featured_image_id, status, published_at, meta_tags, meta_title, meta_description, views, created_at, updated_at, deleted_at) FROM stdin;
1	test news	test-news		<p>test news</p>	1	1	6	published	2025-12-15 13:04:00	\N			0	2025-12-15 13:05:16	2025-12-15 13:05:16	\N
2	sadad	dasdasd	asdasd	<p>fsdfdsf</p>	1	1	7	published	2025-12-15 16:11:00	\N			0	2025-12-15 16:11:55	2025-12-15 16:11:55	\N
3	cbcvb	cvbcvb	cvbcvb	<p>vcbcvb</p>	1	1	8	published	2025-12-15 16:12:00	\N			0	2025-12-15 16:12:29	2025-12-15 16:12:29	\N
4	外国投资者签证问题	intax-montsame	蒙通社乌兰巴托12月15日电，在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。	<p><strong>蒙通社乌兰巴托12月15日电，</strong>在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;蒙古国的签证类别包括：公务、投资、劳务、留学、探亲、移民、因私、宗教及临时签证等。其中，外国投资者、投资者代表、执行董事、代表处管理人员及其家属需申请 B 类签证；而从事建筑、采矿、科学、教育、金融、经济、农业、医疗保健、人道主义及货运等行业的外国人则需申请 C 类（劳务）签证。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;此外，外国公民因商务活动、旅游、运输进口货物或运送乘客而临时入境蒙古国的，则须申请 K 类签证。外国公民在入境蒙古国后应在 21 个日历日内办理居留许可。在申请签证及居留手续时，申请人需取得投资与贸易机构、劳动协调局、社会保险机关及税务机关的相关证明，并按照要求准备其他必要材料，通过电子方式向移民局提交申请。</p><p style="text-align: justify;">&nbsp; &nbsp; &nbsp;对于签证有效期，申请投资签证的外国公民可获得最长1年的居留许可，每次续签期限最长为3年。对于持有由劳动事务主管机关及其授权机构颁发的工作许可的外国公民，根据其工作许可居留许可有效期最长为1年，每次续签期限最长为1年。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;如果移民局拒绝签发签证、签证许可或签证延期申请，根据《外国人法律地位法》第20.4条的规定，外国公民或邀请机构无需说明拒绝理由。因此，外国公民或邀请机构在申请签证时，必须如实、完整、条理清楚地提供申请依据及相关证明材料，以便快速高效地处理签证申请。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;投资者在设立公司或申请签证时，通常会因为委托未经核实的人员或熟人填写材料而导致个人信息泄露、受骗，并遭受金钱和时间的损失。因此，最好委托专业机构的服务，以保护自身免受潜在风险的影响，并使您能够全身心专注于自身业务。</p><p style="text-align: justify;"><strong><br></strong></p><p style="text-align: justify;"><strong>如有意获更多信息，请致电 +976-77218818 ，+976-99222288</strong></p><p style="text-align: justify;"><strong>微信：saraachimgee</strong></p><p style="text-align: justify;"><a target="_blank" rel="noopener noreferrer nofollow" href="mailto:邮箱：saranchimeg-ceo@intax.mn"><strong>邮箱：saranchimeg-ceo@intax.mn</strong></a></p><p style="text-align: justify;"></p><p style="text-align: justify;"><strong>网站：</strong><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.intax.mn"><strong>www.intax.mn</strong></a></p>	1	1	10	published	2025-12-15 18:20:00	\N			0	2025-12-15 18:21:05	2025-12-15 18:21:05	\N
\.


--
-- Data for Name: role_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_user (role_id, user_id) FROM stdin;
1	1
3	2
4	3
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, slug, description, created_at, updated_at) FROM stdin;
1	Super Admin	super-admin	Has full access to all features	2025-12-15 10:28:29	2025-12-15 10:28:29
2	Admin	admin	Can manage content and users	2025-12-15 10:28:29	2025-12-15 10:28:29
3	Editor	editor	Can create and edit content	2025-12-15 10:28:29	2025-12-15 10:28:29
4	Author	author	Can create own content	2025-12-15 10:28:29	2025-12-15 10:28:29
\.


--
-- Data for Name: service_sections; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.service_sections (id, service_id, title, content, type, icon, "order", is_active, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: service_widgets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.service_widgets (id, service_id, widget_id, "order", created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: services; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.services (id, slug, icon, featured_image_id, is_active, "order", created_at, updated_at, deleted_at) FROM stdin;
1	tax-service	📊	\N	t	1	2025-12-15 15:59:24	2025-12-15 15:59:24	\N
2	accouning	📋	\N	t	2	2025-12-15 16:00:25	2025-12-15 16:00:25	\N
3	legal	⚖️	\N	t	3	2025-12-15 16:01:07	2025-12-15 16:01:07	\N
4	visa	🛂	\N	t	4	2025-12-15 16:01:54	2025-12-15 16:01:54	\N
5	company	🏢	\N	t	5	2025-12-15 16:03:05	2025-12-15 16:03:05	\N
6	import-service	📦	\N	t	6	2025-12-15 16:04:50	2025-12-15 16:04:50	\N
7	translation	🌐	\N	t	7	2025-12-15 16:05:42	2025-12-15 16:05:42	\N
8	investment	🤝	\N	t	8	2025-12-15 16:06:29	2025-12-15 16:06:29	\N
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
x1CTDbHIUUqLOPoYhEjPrWNfG0ahO5hLVE4JXDr6	\N	127.0.0.1	Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOXlFZzFhZ1BobjEzem0wZXhOQXFBMlhDZzdBcDZwbjcyUVB0TEpjTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiemgiO3M6MjI6ImFjdGl2ZV9uYXZpZ2F0aW9uX21lbnUiO3M6NzoicHJpbWFyeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vd3d3LmludGF4LnRlc3QvemgiO319	1768115842
R98kxoxhHd0oEyHAdsJmLXSPknR0RRneVrD0ervH	\N	127.0.0.1	Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVUJlemJMV281MGl6UnlXZFFTOTRPamdYUmphZmNRcFAzMWxtOU4wMSI7czo2OiJsb2NhbGUiO3M6MjoiemgiO3M6MjI6ImFjdGl2ZV9uYXZpZ2F0aW9uX21lbnUiO3M6NzoicHJpbWFyeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vaW50YXgudGVzdC96aC9jb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNDoiY2FwdGNoYV9hbnN3ZXIiO2k6Njt9	1767142112
uiVKKOusvodS99Ssv2AZvk94emwEATVKBrd3TocV	\N	127.0.0.1	Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo2OntzOjY6Il90b2tlbiI7czo0MDoiV2NSU09EMXVWMVM4bUkyMXAyMUxPZFB1VGNKVndCekllSnBmNHA1NyI7czo2OiJsb2NhbGUiO3M6MjoibW4iO3M6MjI6ImFjdGl2ZV9uYXZpZ2F0aW9uX21lbnUiO3M6NzoicHJpbWFyeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50YXgudGVzdC9tbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTQ6ImNhcHRjaGFfYW5zd2VyIjtpOjU7fQ==	1766839081
\.


--
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.settings (id, key, value, type, "group", created_at, updated_at) FROM stdin;
14	general_logo	1	image	general	2025-12-15 10:32:13	2025-12-15 10:32:13
16	general_default_locale	zh	text	general	2025-12-15 10:32:13	2025-12-15 10:32:13
17	general_enabled_locales	en,mn,zh	text	general	2025-12-15 10:32:13	2025-12-15 10:32:13
18	general_editor_type	tiptap	text	general	2025-12-15 10:32:13	2025-12-15 10:32:13
1	general_site_name	InTaxS Councel LLC	text	general	2025-12-15 10:30:04	2025-12-15 10:34:19
2	general_site_description	Манай компани нь гадаад хөрөнгө оруулагчид МУ-д хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах, компани байгуулагдаж эхлэхээс эхлэн үйл ажиллагааг жигдэрүүлэх, цааш тасралтгүй амжилттай үйл ажиллагааг явуулах бүхий л үйл явцыг зохион байгуулах, санхүү татварын бүх төрлийн тайлангууд бэлтгэх, холбогдох байгууллагуудад тайлагнах, зөвлөх үйлчилгээг үзүүлдэг юм.	text	general	2025-12-15 10:30:04	2025-12-15 10:34:19
4	contact_email	saranchimeg-ceo@intax.mn	text	contact	2025-12-15 10:30:04	2025-12-15 10:34:19
5	contact_phone	7721-8818, 9922-2288	text	contact	2025-12-15 10:30:04	2025-12-15 10:34:19
6	contact_address	Khan-Uul District, 17th Khoroo, Zaisan Star Residence, 56-2-92	text	contact	2025-12-15 10:30:04	2025-12-15 10:34:19
7	social_facebook	https://www.facebook.com/profile.php?id=61563460747992	text	social	2025-12-15 10:30:04	2025-12-15 10:34:19
8	social_twitter	\N	text	social	2025-12-15 10:30:04	2025-12-15 10:34:19
9	social_instagram	\N	text	social	2025-12-15 10:30:04	2025-12-15 10:34:19
10	social_linkedin	\N	text	social	2025-12-15 10:30:04	2025-12-15 10:34:19
11	social_youtube	\N	text	social	2025-12-15 10:30:04	2025-12-15 10:34:19
12	footer_copyright	© 2025 InTaxS Councel LLC	text	footer	2025-12-15 10:30:04	2025-12-15 10:34:19
13	footer_about_text	Манай компани нь гадаад хөрөнгө оруулагчид МУ-д хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах, компани байгуулагдаж эхлэхээс эхлэн үйл ажиллагааг жигдэрүүлэх, цааш тасралтгүй амжилттай үйл ажиллагааг явуулах бүхий л үйл явцыг зохион байгуулах, санхүү татварын бүх төрлийн тайлангууд бэлтгэх, холбогдох байгууллагуудад тайлагнах, зөвлөх үйлчилгээг үзүүлдэг юм.	text	footer	2025-12-15 10:30:04	2025-12-15 10:34:19
3	general_primary_color	#d40c19	text	general	2025-12-15 10:30:04	2025-12-15 11:04:13
15	general_favicon	3	image	general	2025-12-15 10:32:13	2025-12-15 11:27:59
\.


--
-- Data for Name: sliders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sliders (id, image_id, button_text, button_url, button_target, is_active, "order", created_at, updated_at) FROM stdin;
2	5	View services	/mn/services	_self	t	0	2025-12-15 12:26:48	2025-12-15 12:48:15
\.


--
-- Data for Name: team_members; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.team_members (id, slug, email, phone, facebook, twitter, linkedin, photo_id, is_active, "order", created_at, updated_at) FROM stdin;
3	sfsf	\N	\N	\N	\N	\N	12	t	3	2025-12-15 18:22:35	2025-12-15 18:50:00
4	dsfdsf	\N	\N	\N	\N	\N	13	t	4	2025-12-15 18:22:54	2025-12-15 18:50:04
5	ewre	\N	\N	\N	\N	\N	14	t	5	2025-12-15 18:23:18	2025-12-15 18:50:09
2	saraachimegee	saranchimeg-ceo@intax.mn	+976-99222288	https://www.facebook.com/saraa.chimgee.7	\N	\N	11	t	2	2025-12-15 18:22:18	2025-12-15 18:52:02
\.


--
-- Data for Name: testimonials; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.testimonials (id, client_name, client_position, client_company, client_photo_id, content, rating, "order", is_active, created_at, updated_at) FROM stdin;
1	Баярсайхан	Захирал	Монгол Технологи ХХК	\N	Маш сайхан хамтын ажиллагаа болсон. Манай вэб сайтыг маш түргэн хугацаанд хийж гүйцэтгэсэн. Ажлын чанар, хурд бүгд маш сайн байлаа. Баярлалаа!	5	1	t	2025-12-15 10:30:08	2025-12-15 10:30:08
2	Сарнай	Маркетингийн менежер	Дижитал Маркетинг ХХК	\N	Бүх зүйл маш мэргэжлийн түвшинд, цаг хугацаандаа хийгдсэн. Вэбсайт маш үзэсгэлэнтэй, хэрэглэхэд хялбар болсон. Санал болгож байна.	5	2	t	2025-12-15 10:30:08	2025-12-15 10:30:08
3	Болд	Гүйцэтгэх захирал	Бизнес Солюшн ХХК	\N	Маш их баярлалаа. Манай бизнесийн онцлогийг маш сайн ойлгож, төгс шийдэл гаргасан. CMS систем нь хэрэглэхэд маш хялбар байна.	5	3	t	2025-12-15 10:30:08	2025-12-15 10:30:08
4	Оюунчимэг	Бүтээгдэхүүний менежер	Инновэйшн Хаб	\N	Үнэхээр найдвартай, мэргэжлийн баг. Манай шаардлагыг бүрэн хангасан вэб систем бүтээсэн. Дэмжлэг үзүүлэх үйлчилгээ нь маш сайн.	5	4	t	2025-12-15 10:30:08	2025-12-15 10:30:08
5	Төмөр	IT менежер	Корпорэйт Групп	\N	Техникийн түвшин өндөр, дизайн орчин үеийн. Вэбсайтын хурд сайн, админ хэсэг хэрэглэхэд амар. 5 од зүтгэж байна!	5	5	t	2025-12-15 10:30:08	2025-12-15 10:30:08
6	Номин	Санхүү захирал	Үндэсний Санхүү	\N	Төсөл цаг хугацаандаа, төсөвтөө багтан хийгдсэн. Баг маш мэргэжлийн, харилцаа маш сайн байлаа. Баярлалаа.	4	6	t	2025-12-15 10:30:08	2025-12-15 10:30:08
7	Ганбаатар	Гүйцэтгэх захирал	Логистик Солюшн	\N	Бидний вэб платформ одоо маш сайхан ажиллаж байна. Хэрэглэгчдийн санал хүсэлт ихсэж, онлайн борлуулалт өссөн. Баярлалаа!	5	7	t	2025-12-15 10:30:08	2025-12-15 10:30:08
8	Цэцэгмаа	Борлуулалтын менежер	E-Commerce Plus	\N	Онлайн дэлгүүрийн систем маань төгс ажиллаж байна. SEO оновчтой бөгөөд Google-д сайн харагддаг болсон. Маш их баярлалаа.	5	8	t	2025-12-15 10:30:08	2025-12-15 10:30:08
\.


--
-- Data for Name: translations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translations (id, translatable_type, translatable_id, locale, field, value, created_at, updated_at) FROM stdin;
1	App\\Models\\MenuItem	1	en	title	Home	2025-12-15 10:28:30	2025-12-15 10:28:30
2	App\\Models\\MenuItem	1	mn	title	Нүүр	2025-12-15 10:28:30	2025-12-15 10:28:30
3	App\\Models\\MenuItem	1	zh	title	首页	2025-12-15 10:28:30	2025-12-15 10:28:30
4	App\\Models\\MenuItem	2	en	title	About	2025-12-15 10:28:30	2025-12-15 10:28:30
5	App\\Models\\MenuItem	2	mn	title	Бидний тухай	2025-12-15 10:28:30	2025-12-15 10:28:30
6	App\\Models\\MenuItem	2	zh	title	关于我们	2025-12-15 10:28:30	2025-12-15 10:28:30
7	App\\Models\\MenuItem	3	en	title	Services	2025-12-15 10:28:30	2025-12-15 10:28:30
8	App\\Models\\MenuItem	3	mn	title	Үйлчилгээ	2025-12-15 10:28:30	2025-12-15 10:28:30
9	App\\Models\\MenuItem	3	zh	title	服务	2025-12-15 10:28:30	2025-12-15 10:28:30
12	App\\Models\\MenuItem	4	zh	title	博客	2025-12-15 10:28:30	2025-12-15 10:28:30
13	App\\Models\\MenuItem	5	en	title	Contact	2025-12-15 10:28:30	2025-12-15 10:28:30
14	App\\Models\\MenuItem	5	mn	title	Холбоо барих	2025-12-15 10:28:30	2025-12-15 10:28:30
15	App\\Models\\MenuItem	5	zh	title	联系我们	2025-12-15 10:28:30	2025-12-15 10:28:30
16	App\\Models\\MenuItem	6	en	title	Home	2025-12-15 10:28:30	2025-12-15 10:28:30
17	App\\Models\\MenuItem	6	mn	title	Нүүр	2025-12-15 10:28:30	2025-12-15 10:28:30
18	App\\Models\\MenuItem	6	zh	title	首页	2025-12-15 10:28:30	2025-12-15 10:28:30
19	App\\Models\\MenuItem	7	en	title	News & Articles	2025-12-15 10:28:30	2025-12-15 10:28:30
20	App\\Models\\MenuItem	7	mn	title	Мэдээ ба нийтлэл	2025-12-15 10:28:30	2025-12-15 10:28:30
21	App\\Models\\MenuItem	7	zh	title	新闻与文章	2025-12-15 10:28:30	2025-12-15 10:28:30
22	App\\Models\\MenuItem	8	en	title	Admin Dashboard	2025-12-15 10:28:30	2025-12-15 10:28:30
23	App\\Models\\MenuItem	8	mn	title	Админ хяналт	2025-12-15 10:28:30	2025-12-15 10:28:30
24	App\\Models\\MenuItem	8	zh	title	管理面板	2025-12-15 10:28:30	2025-12-15 10:28:30
25	App\\Models\\Slider	1	en	title	ertert	2025-12-15 11:49:48	2025-12-15 11:49:48
26	App\\Models\\Slider	1	mn	title	ertert	2025-12-15 11:49:48	2025-12-15 11:49:48
27	App\\Models\\Slider	1	zh	title	ertretert	2025-12-15 11:49:48	2025-12-15 11:49:48
28	App\\Models\\Slider	1	mn	subtitle	sdfsdf	2025-12-15 11:54:16	2025-12-15 11:54:16
29	App\\Models\\Slider	1	mn	description	sdfsdfds	2025-12-15 11:54:16	2025-12-15 11:54:16
30	App\\Models\\Slider	1	en	subtitle	sdfdsf	2025-12-15 11:54:16	2025-12-15 11:54:16
34	App\\Models\\Slider	2	mn	description	Гадаадын хөрөнгө оруулагч болон бизнес эрхлэгчдэд зориулсан иж бүрэн татвар, санхүү, хууль зүйн зөвлөгөө үйлчилгээ. Бид таны бизнесийг Монголд амжилттай явуулахад туслана.	2025-12-15 12:26:48	2025-12-15 12:26:48
38	App\\Models\\Slider	2	en	subtitle	Монгол дахь татвар, санхүү, хуулийн мэргэжлийн зөвлөгөө	2025-12-15 12:27:56	2025-12-15 12:27:56
43	App\\Models\\Slider	2	zh	button_text	查看服务	2025-12-15 12:53:48	2025-12-15 12:53:48
44	App\\Models\\Slider	2	zh	button_url	/zh/services	2025-12-15 12:53:48	2025-12-15 12:53:48
33	App\\Models\\Slider	2	mn	title	Монгол дахь татвар, санхүү, хуулийн мэргэжлийн зөвлөгөө	2025-12-15 12:26:48	2025-12-15 12:29:24
37	App\\Models\\Slider	2	mn	subtitle	...	2025-12-15 12:27:56	2025-12-15 12:29:43
31	App\\Models\\Slider	2	en	title	Professional tax, financial, and legal consulting services in Mongolia	2025-12-15 12:26:48	2025-12-15 12:48:15
32	App\\Models\\Slider	2	en	description	Comprehensive tax, financial, and legal advisory services for foreign investors and business owners. We help you successfully operate and grow your business in Mongolia.	2025-12-15 12:26:48	2025-12-15 12:48:15
35	App\\Models\\Slider	2	zh	title	蒙古的税务、财务和法律专业咨询服务	2025-12-15 12:26:48	2025-12-15 12:48:15
36	App\\Models\\Slider	2	zh	description	为外国投资者和企业家提供全面的税务、财务和法律咨询服务。我们助力您在蒙古国成功开展和发展业务。	2025-12-15 12:26:48	2025-12-15 12:48:15
39	App\\Models\\Slider	2	mn	button_text	Үйлчилгээ харах	2025-12-15 12:53:48	2025-12-15 12:53:48
40	App\\Models\\Slider	2	mn	button_url	/mn/services	2025-12-15 12:53:48	2025-12-15 12:53:48
41	App\\Models\\Slider	2	en	button_text	View services	2025-12-15 12:53:48	2025-12-15 12:53:48
42	App\\Models\\Slider	2	en	button_url	/en/services	2025-12-15 12:53:48	2025-12-15 12:53:48
45	App\\Models\\Category	1	en	name	News	2025-12-15 13:04:33	2025-12-15 13:04:33
46	App\\Models\\Category	1	mn	name	Мэдээ	2025-12-15 13:04:33	2025-12-15 13:04:33
47	App\\Models\\Category	1	zh	name	News	2025-12-15 13:04:33	2025-12-15 13:04:33
48	App\\Models\\Post	1	en	title	test news	2025-12-15 13:05:16	2025-12-15 13:05:16
49	App\\Models\\Post	1	en	content	<p>test news</p>	2025-12-15 13:05:16	2025-12-15 13:05:16
50	App\\Models\\Post	1	mn	title	test news	2025-12-15 13:05:16	2025-12-15 13:05:16
51	App\\Models\\Post	1	mn	content	<p>test news</p>	2025-12-15 13:05:16	2025-12-15 13:05:16
52	App\\Models\\Post	1	zh	title	test news	2025-12-15 13:05:16	2025-12-15 13:05:16
53	App\\Models\\Post	1	zh	content	<p>test news</p>	2025-12-15 13:05:16	2025-12-15 13:05:16
54	App\\Models\\Service	1	en	title	Татварын зөвлөгөө	2025-12-15 15:59:24	2025-12-15 15:59:24
55	App\\Models\\Service	1	en	description	Татварын төлөвлөлт, хөнгөлөлт, чөлөөлөлт, ногдол ашгийн татварын хэмнэлт	2025-12-15 15:59:24	2025-12-15 15:59:24
56	App\\Models\\Service	1	mn	title	Татварын зөвлөгөө	2025-12-15 15:59:24	2025-12-15 15:59:24
57	App\\Models\\Service	1	mn	description	Татварын төлөвлөлт, хөнгөлөлт, чөлөөлөлт, ногдол ашгийн татварын хэмнэлт	2025-12-15 15:59:24	2025-12-15 15:59:24
59	App\\Models\\Service	1	zh	description	Татварын төлөвлөлт, хөнгөлөлт, чөлөөлөлт, ногдол ашгийн татварын хэмнэлт	2025-12-15 15:59:24	2025-12-15 15:59:24
60	App\\Models\\Service	2	en	title	Нягтлан бодох бүртгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
114	App\\Models\\Post	3	mn	title	cbcvb	2025-12-15 16:12:29	2025-12-15 16:12:29
115	App\\Models\\Post	3	mn	excerpt	cvbcvb	2025-12-15 16:12:29	2025-12-15 16:12:29
11	App\\Models\\MenuItem	4	mn	title	Мэдээ	2025-12-15 10:28:30	2025-12-15 20:18:33
58	App\\Models\\Service	1	zh	title	服务	2025-12-15 15:59:24	2025-12-17 18:22:52
61	App\\Models\\Service	2	en	description	Санхүүгийн бүртгэл хөтлөлт, тайлан бэлтгэх, аудит бэлтгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
62	App\\Models\\Service	2	mn	title	Нягтлан бодох бүртгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
63	App\\Models\\Service	2	mn	description	Санхүүгийн бүртгэл хөтлөлт, тайлан бэлтгэх, аудит бэлтгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
64	App\\Models\\Service	2	zh	title	Нягтлан бодох бүртгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
65	App\\Models\\Service	2	zh	description	Санхүүгийн бүртгэл хөтлөлт, тайлан бэлтгэх, аудит бэлтгэл	2025-12-15 16:00:25	2025-12-15 16:00:25
66	App\\Models\\Service	3	en	title	Хуулийн зөвлөгөө	2025-12-15 16:01:07	2025-12-15 16:01:07
67	App\\Models\\Service	3	en	description	Компани байгуулах, гэрээ хэлцэл, лиценз зөвшөөрлийн асуудал	2025-12-15 16:01:07	2025-12-15 16:01:07
68	App\\Models\\Service	3	mn	title	Хуулийн зөвлөгөө	2025-12-15 16:01:07	2025-12-15 16:01:07
69	App\\Models\\Service	3	mn	description	Компани байгуулах, гэрээ хэлцэл, лиценз зөвшөөрлийн асуудал	2025-12-15 16:01:07	2025-12-15 16:01:07
70	App\\Models\\Service	3	zh	title	Хуулийн зөвлөгөө	2025-12-15 16:01:07	2025-12-15 16:01:07
71	App\\Models\\Service	3	zh	description	Компани байгуулах, гэрээ хэлцэл, лиценз зөвшөөрлийн асуудал	2025-12-15 16:01:07	2025-12-15 16:01:07
72	App\\Models\\Service	4	en	title	Виза, оршин суух	2025-12-15 16:01:54	2025-12-15 16:01:54
73	App\\Models\\Service	4	en	description	Гадаадын ажилтны виза, оршин суух зөвшөөрлийн бүрдүүлэлт	2025-12-15 16:01:54	2025-12-15 16:01:54
74	App\\Models\\Service	4	mn	title	Виза, оршин суух	2025-12-15 16:01:54	2025-12-15 16:01:54
75	App\\Models\\Service	4	mn	description	Гадаадын ажилтны виза, оршин суух зөвшөөрлийн бүрдүүлэлт	2025-12-15 16:01:54	2025-12-15 16:01:54
76	App\\Models\\Service	4	zh	title	Виза, оршин суух	2025-12-15 16:01:54	2025-12-15 16:01:54
77	App\\Models\\Service	4	zh	description	Гадаадын ажилтны виза, оршин суух зөвшөөрлийн бүрдүүлэлт	2025-12-15 16:01:54	2025-12-15 16:01:54
78	App\\Models\\Service	5	en	title	Компани бүртгэл	2025-12-15 16:03:05	2025-12-15 16:03:05
79	App\\Models\\Service	5	en	description	Компани үүсгэн байгуулах, өөрчлөлт, татан буулгах үйл ажиллагаа	2025-12-15 16:03:05	2025-12-15 16:03:05
80	App\\Models\\Service	5	mn	title	Компани бүртгэл	2025-12-15 16:03:05	2025-12-15 16:03:05
81	App\\Models\\Service	5	mn	description	Компани үүсгэн байгуулах, өөрчлөлт, татан буулгах үйл ажиллагаа	2025-12-15 16:03:05	2025-12-15 16:03:05
82	App\\Models\\Service	5	zh	title	Компани бүртгэл	2025-12-15 16:03:05	2025-12-15 16:03:05
83	App\\Models\\Service	5	zh	description	Компани үүсгэн байгуулах, өөрчлөлт, татан буулгах үйл ажиллагаа	2025-12-15 16:03:05	2025-12-15 16:03:05
84	App\\Models\\Service	6	en	title	Гааль, импорт	2025-12-15 16:04:50	2025-12-15 16:04:50
85	App\\Models\\Service	6	en	description	Импорт экспортын бичиг баримт, гаалийн бүрдүүлэлт	2025-12-15 16:04:50	2025-12-15 16:04:50
86	App\\Models\\Service	6	mn	title	Гааль, импорт	2025-12-15 16:04:50	2025-12-15 16:04:50
87	App\\Models\\Service	6	mn	description	Импорт экспортын бичиг баримт, гаалийн бүрдүүлэлт	2025-12-15 16:04:50	2025-12-15 16:04:50
88	App\\Models\\Service	6	zh	title	Гааль, импорт	2025-12-15 16:04:50	2025-12-15 16:04:50
89	App\\Models\\Service	6	zh	description	Импорт экспортын бичиг баримт, гаалийн бүрдүүлэлт	2025-12-15 16:04:50	2025-12-15 16:04:50
90	App\\Models\\Service	7	en	title	Орчуулгын үйлчилгээ	2025-12-15 16:05:42	2025-12-15 16:05:42
91	App\\Models\\Service	7	en	description	Монгол-Хятад-Англи бичгийн болон амаар орчуулга	2025-12-15 16:05:42	2025-12-15 16:05:42
92	App\\Models\\Service	7	mn	title	Орчуулгын үйлчилгээ	2025-12-15 16:05:42	2025-12-15 16:05:42
93	App\\Models\\Service	7	mn	description	Монгол-Хятад-Англи бичгийн болон амаар орчуулга	2025-12-15 16:05:42	2025-12-15 16:05:42
94	App\\Models\\Service	7	zh	title	Орчуулгын үйлчилгээ	2025-12-15 16:05:42	2025-12-15 16:05:42
95	App\\Models\\Service	7	zh	description	Монгол-Хятад-Англи бичгийн болон амаар орчуулга	2025-12-15 16:05:42	2025-12-15 16:05:42
96	App\\Models\\Service	8	en	title	Хөрөнгө оруулалт	2025-12-15 16:06:30	2025-12-15 16:06:30
97	App\\Models\\Service	8	en	description	Төсөл хөрөнгө оруулалтын зуучлал, тендерийн бичиг баримт	2025-12-15 16:06:30	2025-12-15 16:06:30
98	App\\Models\\Service	8	mn	title	Хөрөнгө оруулалт	2025-12-15 16:06:30	2025-12-15 16:06:30
99	App\\Models\\Service	8	mn	description	Төсөл хөрөнгө оруулалтын зуучлал, тендерийн бичиг баримт	2025-12-15 16:06:30	2025-12-15 16:06:30
100	App\\Models\\Service	8	zh	title	Хөрөнгө оруулалт	2025-12-15 16:06:30	2025-12-15 16:06:30
101	App\\Models\\Service	8	zh	description	Төсөл хөрөнгө оруулалтын зуучлал, тендерийн бичиг баримт	2025-12-15 16:06:30	2025-12-15 16:06:30
102	App\\Models\\Post	2	en	title	sadad	2025-12-15 16:11:55	2025-12-15 16:11:55
103	App\\Models\\Post	2	en	excerpt	asdasd	2025-12-15 16:11:55	2025-12-15 16:11:55
104	App\\Models\\Post	2	en	content	<p>fsdfdsf</p>	2025-12-15 16:11:55	2025-12-15 16:11:55
105	App\\Models\\Post	2	mn	title	asdsad	2025-12-15 16:11:55	2025-12-15 16:11:55
106	App\\Models\\Post	2	mn	excerpt	asdsad	2025-12-15 16:11:55	2025-12-15 16:11:55
107	App\\Models\\Post	2	mn	content	<p>dsfsfs</p>	2025-12-15 16:11:55	2025-12-15 16:11:55
108	App\\Models\\Post	2	zh	title	asdsad	2025-12-15 16:11:55	2025-12-15 16:11:55
109	App\\Models\\Post	2	zh	excerpt	asdsad	2025-12-15 16:11:55	2025-12-15 16:11:55
110	App\\Models\\Post	2	zh	content	<p>asdasdasd</p>	2025-12-15 16:11:55	2025-12-15 16:11:55
111	App\\Models\\Post	3	en	title	cbcvb	2025-12-15 16:12:29	2025-12-15 16:12:29
112	App\\Models\\Post	3	en	excerpt	cvbcvb	2025-12-15 16:12:29	2025-12-15 16:12:29
113	App\\Models\\Post	3	en	content	<p>vcbcvb</p>	2025-12-15 16:12:29	2025-12-15 16:12:29
116	App\\Models\\Post	3	mn	content	<p>cvbcvb</p>	2025-12-15 16:12:29	2025-12-15 16:12:29
117	App\\Models\\Post	3	zh	title	cvbcvb	2025-12-15 16:12:29	2025-12-15 16:12:29
118	App\\Models\\Post	3	zh	excerpt	cvbvcb	2025-12-15 16:12:29	2025-12-15 16:12:29
119	App\\Models\\Post	3	zh	content	<p>vcbvcb</p>	2025-12-15 16:12:29	2025-12-15 16:12:29
122	App\\Models\\Page	1	mn	title	Бидний тухай	2025-12-15 17:40:49	2025-12-15 17:40:49
127	App\\Models\\TeamMember	1	en	position	dsfsdf	2025-12-15 17:48:10	2025-12-15 17:48:10
130	App\\Models\\TeamMember	1	zh	name	dsfsdf	2025-12-15 17:48:10	2025-12-15 17:48:10
131	App\\Models\\TeamMember	1	zh	position	dsfdsfdsf	2025-12-15 17:48:10	2025-12-15 17:48:10
132	App\\Models\\Page	1	mn	meta_title		2025-12-15 18:05:09	2025-12-15 18:05:09
133	App\\Models\\Page	1	mn	meta_description		2025-12-15 18:05:09	2025-12-15 18:05:09
134	App\\Models\\Page	1	en	meta_title		2025-12-15 18:05:09	2025-12-15 18:05:09
135	App\\Models\\Page	1	en	meta_description		2025-12-15 18:05:09	2025-12-15 18:05:09
136	App\\Models\\Page	1	zh	meta_title		2025-12-15 18:05:09	2025-12-15 18:05:09
137	App\\Models\\Page	1	zh	meta_description		2025-12-15 18:05:09	2025-12-15 18:05:09
124	App\\Models\\Page	1	zh	title	关于我们	2025-12-15 17:40:49	2025-12-15 18:41:15
120	App\\Models\\Page	1	en	title	About us	2025-12-15 17:40:49	2025-12-15 18:41:15
138	App\\Models\\Post	4	en	title	外国投资者签证问题	2025-12-15 18:21:05	2025-12-15 18:21:05
139	App\\Models\\Post	4	en	excerpt	蒙通社乌兰巴托12月15日电，在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。	2025-12-15 18:21:05	2025-12-15 18:21:05
140	App\\Models\\Post	4	en	content	<p><strong>蒙通社乌兰巴托12月15日电，</strong>在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;蒙古国的签证类别包括：公务、投资、劳务、留学、探亲、移民、因私、宗教及临时签证等。其中，外国投资者、投资者代表、执行董事、代表处管理人员及其家属需申请 B 类签证；而从事建筑、采矿、科学、教育、金融、经济、农业、医疗保健、人道主义及货运等行业的外国人则需申请 C 类（劳务）签证。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;此外，外国公民因商务活动、旅游、运输进口货物或运送乘客而临时入境蒙古国的，则须申请 K 类签证。外国公民在入境蒙古国后应在 21 个日历日内办理居留许可。在申请签证及居留手续时，申请人需取得投资与贸易机构、劳动协调局、社会保险机关及税务机关的相关证明，并按照要求准备其他必要材料，通过电子方式向移民局提交申请。</p><p style="text-align: justify;">&nbsp; &nbsp; &nbsp;对于签证有效期，申请投资签证的外国公民可获得最长1年的居留许可，每次续签期限最长为3年。对于持有由劳动事务主管机关及其授权机构颁发的工作许可的外国公民，根据其工作许可居留许可有效期最长为1年，每次续签期限最长为1年。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;如果移民局拒绝签发签证、签证许可或签证延期申请，根据《外国人法律地位法》第20.4条的规定，外国公民或邀请机构无需说明拒绝理由。因此，外国公民或邀请机构在申请签证时，必须如实、完整、条理清楚地提供申请依据及相关证明材料，以便快速高效地处理签证申请。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;投资者在设立公司或申请签证时，通常会因为委托未经核实的人员或熟人填写材料而导致个人信息泄露、受骗，并遭受金钱和时间的损失。因此，最好委托专业机构的服务，以保护自身免受潜在风险的影响，并使您能够全身心专注于自身业务。</p><p style="text-align: justify;"><strong><br></strong></p><p style="text-align: justify;"><strong>如有意获更多信息，请致电 +976-77218818 ，+976-99222288</strong></p><p style="text-align: justify;"><strong>微信：saraachimgee</strong></p><p style="text-align: justify;"><a target="_blank" rel="noopener noreferrer nofollow" href="mailto:邮箱：saranchimeg-ceo@intax.mn"><strong>邮箱：saranchimeg-ceo@intax.mn</strong></a></p><p style="text-align: justify;"></p><p style="text-align: justify;"><strong>网站：</strong><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.intax.mn"><strong>www.intax.mn</strong></a></p>	2025-12-15 18:21:05	2025-12-15 18:21:05
141	App\\Models\\Post	4	mn	title	外国投资者签证问题	2025-12-15 18:21:05	2025-12-15 18:21:05
142	App\\Models\\Post	4	mn	excerpt	蒙通社乌兰巴托12月15日电，在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。	2025-12-15 18:21:05	2025-12-15 18:21:05
143	App\\Models\\Post	4	mn	content	<p><span><strong>蒙通社乌兰巴托12月15日电，</strong></span>在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;蒙古国的签证类别包括：公务、投资、劳务、留学、探亲、移民、因私、宗教及临时签证等。其中，外国投资者、投资者代表、执行董事、代表处管理人员及其家属需申请 B 类签证；而从事建筑、采矿、科学、教育、金融、经济、农业、医疗保健、人道主义及货运等行业的外国人则需申请 C 类（劳务）签证。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;此外，外国公民因商务活动、旅游、运输进口货物或运送乘客而临时入境蒙古国的，则须申请 K 类签证。外国公民在入境蒙古国后应在 21 个日历日内办理居留许可。在申请签证及居留手续时，申请人需取得投资与贸易机构、劳动协调局、社会保险机关及税务机关的相关证明，并按照要求准备其他必要材料，通过电子方式向移民局提交申请。</p><p style="text-align: justify;">&nbsp; &nbsp; &nbsp;对于签证有效期，申请投资签证的外国公民可获得最长1年的居留许可，每次续签期限最长为3年。对于持有由劳动事务主管机关及其授权机构颁发的工作许可的外国公民，根据其工作许可居留许可有效期最长为1年，每次续签期限最长为1年。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;如果移民局拒绝签发签证、签证许可或签证延期申请，根据《外国人法律地位法》第20.4条的规定，外国公民或邀请机构无需说明拒绝理由。因此，外国公民或邀请机构在申请签证时，必须如实、完整、条理清楚地提供申请依据及相关证明材料，以便快速高效地处理签证申请。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;投资者在设立公司或申请签证时，通常会因为委托未经核实的人员或熟人填写材料而导致个人信息泄露、受骗，并遭受金钱和时间的损失。因此，最好委托专业机构的服务，以保护自身免受潜在风险的影响，并使您能够全身心专注于自身业务。</p><p style="text-align: justify;"><span><strong><br></strong></span></p><p style="text-align: justify;"><span><strong>如有意获更多信息，请致电 +976-77218818 ，+976-99222288</strong></span></p><p style="text-align: justify;"><span><strong>微信：saraachimgee</strong></span></p><p style="text-align: justify;"><a target="_blank" rel="noopener noreferrer nofollow" href="mailto:邮箱：saranchimeg-ceo@intax.mn"><span><strong>邮箱：saranchimeg-ceo@intax.mn</strong></span></a></p><p style="text-align: justify;"></p><p style="text-align: justify;"><span><strong>网站：</strong></span><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.intax.mn"><span><strong>www.intax.mn</strong></span></a></p>	2025-12-15 18:21:05	2025-12-15 18:21:05
144	App\\Models\\Post	4	zh	title	外国投资者签证问题	2025-12-15 18:21:05	2025-12-15 18:21:05
145	App\\Models\\Post	4	zh	excerpt	蒙通社乌兰巴托12月15日电，在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。	2025-12-15 18:21:05	2025-12-15 18:21:05
128	App\\Models\\TeamMember	1	mn	name	Saraa chimegee	2025-12-15 17:48:10	2025-12-15 18:49:24
129	App\\Models\\TeamMember	1	mn	position	CEO	2025-12-15 17:48:10	2025-12-15 18:49:24
126	App\\Models\\TeamMember	1	en	name	Sa	2025-12-15 17:48:10	2025-12-15 18:49:24
146	App\\Models\\Post	4	zh	content	<p><strong>蒙通社乌兰巴托12月15日电，</strong>在蒙古国设立公司的外国投资者及其员工，首先需要关注的重要事项之一便是签证问题。《投资法》第12.1.5条规定，依法向在蒙古国投资的外国投资者及其家属签发多次往返签证及长期居留许可。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;蒙古国的签证类别包括：公务、投资、劳务、留学、探亲、移民、因私、宗教及临时签证等。其中，外国投资者、投资者代表、执行董事、代表处管理人员及其家属需申请 B 类签证；而从事建筑、采矿、科学、教育、金融、经济、农业、医疗保健、人道主义及货运等行业的外国人则需申请 C 类（劳务）签证。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;此外，外国公民因商务活动、旅游、运输进口货物或运送乘客而临时入境蒙古国的，则须申请 K 类签证。外国公民在入境蒙古国后应在 21 个日历日内办理居留许可。在申请签证及居留手续时，申请人需取得投资与贸易机构、劳动协调局、社会保险机关及税务机关的相关证明，并按照要求准备其他必要材料，通过电子方式向移民局提交申请。</p><p style="text-align: justify;">&nbsp; &nbsp; &nbsp;对于签证有效期，申请投资签证的外国公民可获得最长1年的居留许可，每次续签期限最长为3年。对于持有由劳动事务主管机关及其授权机构颁发的工作许可的外国公民，根据其工作许可居留许可有效期最长为1年，每次续签期限最长为1年。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;如果移民局拒绝签发签证、签证许可或签证延期申请，根据《外国人法律地位法》第20.4条的规定，外国公民或邀请机构无需说明拒绝理由。因此，外国公民或邀请机构在申请签证时，必须如实、完整、条理清楚地提供申请依据及相关证明材料，以便快速高效地处理签证申请。</p><p style="text-align: justify;"></p><p style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;投资者在设立公司或申请签证时，通常会因为委托未经核实的人员或熟人填写材料而导致个人信息泄露、受骗，并遭受金钱和时间的损失。因此，最好委托专业机构的服务，以保护自身免受潜在风险的影响，并使您能够全身心专注于自身业务。</p><p style="text-align: justify;"><strong><br></strong></p><p style="text-align: justify;"><strong>如有意获更多信息，请致电 +976-77218818 ，+976-99222288</strong></p><p style="text-align: justify;"><strong>微信：saraachimgee</strong></p><p style="text-align: justify;"><a target="_blank" rel="noopener noreferrer nofollow" href="mailto:邮箱：saranchimeg-ceo@intax.mn"><strong>邮箱：saranchimeg-ceo@intax.mn</strong></a></p><p style="text-align: justify;"></p><p style="text-align: justify;"><strong>网站：</strong><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.intax.mn"><strong>www.intax.mn</strong></a></p>	2025-12-15 18:21:05	2025-12-15 18:21:05
153	App\\Models\\TeamMember	3	en	name	dfsdf	2025-12-15 18:22:35	2025-12-15 18:22:35
154	App\\Models\\TeamMember	3	en	position	sdfsdf	2025-12-15 18:22:35	2025-12-15 18:22:35
155	App\\Models\\TeamMember	3	mn	name	dfdsf	2025-12-15 18:22:35	2025-12-15 18:22:35
156	App\\Models\\TeamMember	3	mn	position	sdfdsf	2025-12-15 18:22:35	2025-12-15 18:22:35
157	App\\Models\\TeamMember	3	zh	name	dfdsf	2025-12-15 18:22:35	2025-12-15 18:22:35
158	App\\Models\\TeamMember	3	zh	position	sdfdsf	2025-12-15 18:22:35	2025-12-15 18:22:35
159	App\\Models\\TeamMember	4	en	name	sdfdsf	2025-12-15 18:22:54	2025-12-15 18:22:54
160	App\\Models\\TeamMember	4	en	position	sdfdsf	2025-12-15 18:22:54	2025-12-15 18:22:54
161	App\\Models\\TeamMember	4	mn	name	dfdsf	2025-12-15 18:22:54	2025-12-15 18:22:54
162	App\\Models\\TeamMember	4	mn	position	dsfsdf	2025-12-15 18:22:54	2025-12-15 18:22:54
163	App\\Models\\TeamMember	4	zh	name	dfdsf	2025-12-15 18:22:54	2025-12-15 18:22:54
164	App\\Models\\TeamMember	4	zh	position	dsfsdf	2025-12-15 18:22:54	2025-12-15 18:22:54
165	App\\Models\\TeamMember	5	en	name	werwer	2025-12-15 18:23:18	2025-12-15 18:23:18
166	App\\Models\\TeamMember	5	en	position	ewrwer	2025-12-15 18:23:18	2025-12-15 18:23:18
167	App\\Models\\TeamMember	5	mn	name	werwer	2025-12-15 18:23:18	2025-12-15 18:23:18
168	App\\Models\\TeamMember	5	mn	position	ewrwre	2025-12-15 18:23:18	2025-12-15 18:23:18
169	App\\Models\\TeamMember	5	zh	name	erwr	2025-12-15 18:23:18	2025-12-15 18:23:18
170	App\\Models\\TeamMember	5	zh	position	ewrewr	2025-12-15 18:23:18	2025-12-15 18:23:18
121	App\\Models\\Page	1	en	content	<p><img src="/storage/uploads/1765795029_intax-logo.png" style="display: block; margin-left: auto; margin-right: auto;"></p><p>Intax S Counsel LLC is a professional advisory firm providing <strong>comprehensive tax, financial, and legal consulting services</strong> to foreign investors seeking to successfully establish and expand their businesses in Mongolia. By integrating international business practices with Mongolia’s legal and regulatory framework, we deliver practical, clear, and actionable solutions tailored to investors’ needs.</p><p>Our company works closely with clients throughout every stage of their business journey — from initial company formation to operational stabilization and sustainable growth. This includes introducing Mongolia’s tax, financial, and legal environment, assisting with proper investment planning, efficient use of capital, and providing guidance to mitigate potential risks.</p><p>In addition to preparing all types of financial and tax reports and submitting them to relevant government authorities in compliance with applicable laws, we provide ongoing accounting and advisory services related to daily business operations. Through these services, we help ensure that our clients’ businesses operate transparently, sustainably, and in full compliance with Mongolian regulations.</p><p>Our team places strong emphasis on ensuring that foreign investors’ capital is utilized <strong>legally, transparently, and efficiently</strong>, protecting businesses from fraud, mismanagement, and legal risks, and supporting their long-term success in Mongolia. Furthermore, by professionally managing the tax and financial reporting of foreign-invested companies, we aim to contribute to the proper formation of tax revenues and make a tangible contribution to Mongolia’s economic development.</p><p>Guided by professional ethics, transparency, and accountability, we strive to build long-term, value-driven partnerships tailored to each client’s specific needs. Intax S Counsel LLC is a competent and responsible team committed to serving as a <strong>trusted bridge between foreign investors and Mongolia’s business environment</strong>, fostering stable and mutually beneficial cooperation.</p>	2025-12-15 17:40:49	2025-12-15 18:39:28
149	App\\Models\\TeamMember	2	mn	name	Saraa Chimegee	2025-12-15 18:22:18	2025-12-15 18:51:46
150	App\\Models\\TeamMember	2	mn	position	CEO	2025-12-15 18:22:18	2025-12-15 18:51:46
147	App\\Models\\TeamMember	2	en	name	Saraa Chimegee	2025-12-15 18:22:18	2025-12-15 18:51:46
148	App\\Models\\TeamMember	2	en	position	CEO	2025-12-15 18:22:18	2025-12-15 18:51:46
151	App\\Models\\TeamMember	2	zh	name	Saraa Chimegee	2025-12-15 18:22:18	2025-12-15 18:51:46
152	App\\Models\\TeamMember	2	zh	position	CEO	2025-12-15 18:22:18	2025-12-15 18:51:46
184	App\\Models\\PageSection	1	en	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:24:56	2025-12-15 19:24:56
125	App\\Models\\Page	1	zh	content	<p><img src="/storage/uploads/1765795029_intax-logo.png" style="display: block; margin-left: auto; margin-right: auto;"></p><p>ntax S Counsel 有限责任公司是一家专业咨询机构，致力于为外国投资者在蒙古国成功设立并拓展业务提供<strong>全面的税务、财务及法律咨询服务</strong>。我们将国际商业实践与蒙古国的法律及监管环境相结合，为投资者提供务实、清晰且可落地的解决方案。</p><p>公司从企业设立初期开始，全程与客户紧密合作，直至企业运营稳定并实现可持续发展。服务内容包括介绍蒙古国的税务、财务及法律环境，协助合理规划投资、提高资金使用效率，并提供风险预防与管理方面的专业建议。</p><p>除依法编制各类财务和税务报表并向相关政府机构申报外，我们还提供持续性的会计及日常经营相关的咨询服务，确保客户的业务运营透明、稳定，并符合蒙古国现行法律法规的要求。</p><p>我们的团队高度重视外国投资资金的<strong>合法、透明和高效使用</strong>，通过防范欺诈、管理不善及法律风险，支持企业在蒙古国实现长期稳健发展。同时，通过专业规范地执行外商投资企业的税务与财务申报工作，我们致力于合理促进税收形成，为蒙古国经济发展作出切实贡献。</p><p>我们始终秉持专业操守、透明原则与高度责任感，致力于根据客户的具体需求建立以长期价值创造为导向的合作关系。Intax S Counsel 有限责任公司立志成为外国投资者与蒙古国商业环境之间的<strong>可信赖桥梁</strong>，推动稳定、互利的长期合作。</p>	2025-12-15 17:40:49	2025-12-15 18:39:28
171	App\\Models\\Page	2	en	title	Манай үйлчилгээ	2025-12-15 18:54:39	2025-12-15 18:54:39
173	App\\Models\\Page	2	mn	title	Манай үйлчилгээ	2025-12-15 18:54:39	2025-12-15 18:54:39
175	App\\Models\\Page	2	zh	title	Манай үйлчилгээ	2025-12-15 18:54:39	2025-12-15 18:54:39
177	App\\Models\\Page	2	mn	meta_title		2025-12-15 18:58:45	2025-12-15 18:58:45
178	App\\Models\\Page	2	mn	meta_description		2025-12-15 18:58:45	2025-12-15 18:58:45
179	App\\Models\\Page	2	en	meta_title		2025-12-15 18:58:45	2025-12-15 18:58:45
180	App\\Models\\Page	2	en	meta_description		2025-12-15 18:58:45	2025-12-15 18:58:45
181	App\\Models\\Page	2	zh	meta_title		2025-12-15 18:58:45	2025-12-15 18:58:45
182	App\\Models\\Page	2	zh	meta_description		2025-12-15 18:58:45	2025-12-15 18:58:45
185	App\\Models\\PageSection	1	mn	title	Манай компанийн давуу тал	2025-12-15 19:24:56	2025-12-15 19:24:56
176	App\\Models\\Page	2	zh	content	<p></p><p style="text-align: justify;"><img src="https://www.intax.test/storage/uploads/1765796859_accounting.jpg" width="483" height="286" style="float: right; margin-left: 1rem; margin-bottom: 0.5rem;">Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм. Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.<br><br>Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.</p>	2025-12-15 18:54:39	2025-12-15 20:05:12
186	App\\Models\\PageSection	1	mn	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:24:56	2025-12-15 19:24:56
187	App\\Models\\PageSection	1	zh	title	Манай компанийн давуу тал	2025-12-15 19:24:56	2025-12-15 19:24:56
188	App\\Models\\PageSection	1	zh	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:24:56	2025-12-15 19:24:56
183	App\\Models\\PageSection	1	en	title	Манай компанийн давуу тал	2025-12-15 19:24:56	2025-12-15 19:24:56
174	App\\Models\\Page	2	mn	content	<p style="text-align: justify;"><img src="https://www.intax.test/storage/uploads/1765796859_accounting.jpg" width="483" height="286" style="float: left; margin: 10px;">Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм. Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.<br><br>Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.</p>	2025-12-15 18:54:39	2025-12-15 20:07:03
123	App\\Models\\Page	1	mn	content	<p></p><p style="text-align: center;"><img src="https://www.intax.test/storage/uploads/1765795029_intax-logo.png" style="display: block; margin-left: auto; margin-right: auto;"></p><p style="text-align: justify;">Интакс Эс Каунсл ХХК нь гадаадын хөрөнгө оруулагчид Монгол Улсад хөрөнгө оруулж, бизнесээ амжилттай эхлүүлэх, өргөжүүлэн тэлэхэд нь дэмжлэг үзүүлэх зорилгоор татвар, санхүү, хууль эрх зүйн <strong>цогц зөвлөх үйлчилгээ</strong> үзүүлдэг мэргэжлийн байгууллага юм. Бид олон улсын бизнесийн онцлог, Монгол Улсын хууль эрх зүйн орчныг уялдуулан, хөрөнгө оруулагчдад бодит, ойлгомжтой, хэрэгжихүйц шийдлүүдийг санал болгодог.</p><p style="text-align: justify;"></p><p style="text-align: justify;">Манай компани нь компанийн үүсгэн байгуулалтын эхний шатнаас эхлэн үйл ажиллагаа жигдэрч, тогтвортой хөгжих хүртэлх бүхий л үе шатанд харилцагчидтайгаа хамтран ажиллаж, бодит дэмжлэг үзүүлдэг. Үүнд Монгол Улсын татвар, санхүү, хууль эрх зүйн орчныг танилцуулах, хөрөнгө оруулалтыг зөв төлөвлөх, үр ашигтай зарцуулах, болзошгүй эрсдэлээс урьдчилан сэргийлэх зөвлөмж багтана.</p><p style="text-align: justify;"></p><p style="text-align: justify;">Бид санхүү, татварын бүх төрлийн тайлан бэлтгэх, холбогдох төрийн байгууллагуудад хууль тогтоомжийн дагуу тайлагнах, нягтлан бодох бүртгэлийн байнгын үйлчилгээ үзүүлэхээс гадна бизнесийн өдөр тутмын үйл ажиллагаатай холбоотой татвар, санхүү, хууль эрх зүйн зөвлөгөөг тогтмол хүргэж ажилладаг. Ингэснээр харилцагчдын үйл ажиллагаа ил тод, тогтвортой, хуульд нийцсэн байдлаар явагдах нөхцөлийг бүрдүүлдэг.</p><p style="text-align: justify;"></p><p style="text-align: justify;">Манай хамт олон нь гадаадын хөрөнгө оруулагчдын оруулсан хөрөнгийг хууль ёсны, ил тод, үр ашигтай зарцуулахад онцгой анхаарч, залилан мэхлэлт, буруу зохион байгуулалт, хууль эрх зүйн эрсдэлээс хамгаалах замаар тэдний бизнесийг Монгол Улсад урт хугацаанд амжилттай хөгжихөд нь дэмжлэг үзүүлдэг. Мөн гадаадын хөрөнгө оруулалттай компаниудын татвар, санхүүгийн тайлагналыг мэргэжлийн түвшинд хэрэгжүүлснээр Монгол Улсын татварын орлогыг зохистой бүрдүүлэх, улмаар улсын эдийн засгийн хөгжилд бодит хувь нэмэр оруулахыг зорьдог.</p><p style="text-align: justify;"></p><p style="text-align: justify;">Бид үйл ажиллагаандаа мэргэжлийн ёс зүй, ил тод байдал, хариуцлагыг эрхэмлэж, харилцагч бүрийн онцлог хэрэгцээнд нийцсэн, урт хугацаанд үнэ цэн бүтээх түншлэлд чиглэсэн хамтын ажиллагааг бий болгохыг зорьдог. Интакс Эс Каунсл ХХК нь гадаадын хөрөнгө оруулагч болон Монгол Улсын бизнесийн орчны хоорондын <strong>итгэлцэлтэй гүүр</strong> болж, харилцан ашигтай, тогтвортой хамтын ажиллагааг хөгжүүлэхэд чиглэн ажилладаг чадварлаг, хариуцлагатай хамт олон юм.</p><p style="text-align: justify;"></p>	2025-12-15 17:40:49	2025-12-15 19:25:15
189	App\\Models\\PageSection	2	en	title	Манай компанийн давуу тал	2025-12-15 19:25:15	2025-12-15 19:25:15
190	App\\Models\\PageSection	2	en	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:25:15	2025-12-15 19:25:15
191	App\\Models\\PageSection	2	mn	title	Манай компанийн давуу тал	2025-12-15 19:25:15	2025-12-15 19:25:15
192	App\\Models\\PageSection	2	mn	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:25:15	2025-12-15 19:25:15
193	App\\Models\\PageSection	2	zh	title	Манай компанийн давуу тал	2025-12-15 19:25:15	2025-12-15 19:25:15
194	App\\Models\\PageSection	2	zh	content	<ul><li><p>Зардал хэмнэнэ – /Байгууллага нь ажилтанд цалин олгохоос гадна Нийгмийн даатгалын шимтгэл 12.5%-14.5% улсад төлдөг нь байгууллагын зардлын томоохон хэсэг болдог/</p></li><li><p>Тогтвортой, цаг хугацаа хэмнэнэ – /Ажилтан ажлаас гарахад ажилд хүн сургах, шинээр хүн хайх зэрэгт цаг хугацаа их зарцуулхаас гадна компанийн үйл ажиллагаа алдагдаж тогтворгүй байдал үүсэхээс сэргийлнэ/</p></li><li><p>Татвараа үнэн зөв тодорхойлсноор хуулийн хүрээнд бага татвар төлөх боломжийг ашиглах /хөнгөлөлт, чөлөөлөлт, ногдол ашиг гэх мэт/</p></li><li><p>Хөрөнгө оруулагч, захирал нь зөвхөн өөрийн бизнесийн үйл ажиллагаанд 100% анхааран ажиллах боломжтой</p></li></ul><p></p>	2025-12-15 19:25:15	2025-12-15 19:25:15
172	App\\Models\\Page	2	en	content	<p></p><p style="text-align: justify;"><img src="https://www.intax.test/storage/uploads/1765796859_accounting.jpg" width="483" height="286" style="float: right; margin-left: 1rem; margin-bottom: 0.5rem;">Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм. Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.<br><br>Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.Манай компани нь гадаад хөрөнгө оруулагчид Монгол улсад хөрөнгө оруулж, бизнесээ өргөжүүлэн тэлэхэд нь татвар, санхүүгийн хууль эрхзүйн орчныг таниулан ойлгуулах юм.</p>	2025-12-15 18:54:39	2025-12-15 20:05:12
195	App\\Models\\MenuItem	9	en	title	cvbvcb	2025-12-15 20:14:20	2025-12-15 20:14:20
196	App\\Models\\MenuItem	9	mn	title	cvbvcb	2025-12-15 20:14:20	2025-12-15 20:14:20
197	App\\Models\\MenuItem	9	zh	title	cvbcvb	2025-12-15 20:14:20	2025-12-15 20:14:20
10	App\\Models\\MenuItem	4	en	title	News	2025-12-15 10:28:30	2025-12-15 20:18:33
198	App\\Models\\Service	1	en	content	<p>быөббыө</p><p>бы</p><p>ө</p><p>ыб</p><p>ө</p><p>бы</p><p>ө</p><p>бы</p><p>өбө<br></p>	2025-12-15 20:42:16	2025-12-15 20:42:16
199	App\\Models\\Service	1	mn	content	<p>быөббыө</p><p>бы</p><p>ө</p><p>ыб</p><p>ө</p><p>бы</p><p>ө</p><p>бы</p><p>өбө</p>	2025-12-15 20:42:38	2025-12-15 20:42:38
200	App\\Models\\Service	1	zh	content	<p>быөббыө</p><p>бы</p><p>ө</p><p>ыб</p><p>ө</p><p>бы</p><p>ө</p><p>бы</p><p>өбө</p>	2025-12-15 20:42:38	2025-12-15 20:42:38
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	Super Admin	admin@magiccms.com	2025-12-15 10:28:30	$2y$12$7d3gtry.sVh9ACbbAYb04.XcIhORWmfmhcws6xpeEa9HjdizRPr7K	\N	2025-12-15 10:28:30	2025-12-15 10:28:30
2	Editor User	editor@magiccms.com	2025-12-15 10:28:30	$2y$12$amPKRvlwm1WjiiFWPIMWyeg4nAZ41is.QI7sGkADjXwP8rQzmx4LW	\N	2025-12-15 10:28:30	2025-12-15 10:28:30
3	Author User	author@magiccms.com	2025-12-15 10:28:30	$2y$12$Ntwq5tBZpbWKJkOfJ5B8qOjQhUUFOQ9Yhwdq5pGE1/ol5rzLG6nWS	\N	2025-12-15 10:28:30	2025-12-15 10:28:30
\.


--
-- Data for Name: widgets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.widgets (id, key, name, type, content, area, "order", is_active, created_at, updated_at) FROM stdin;
1	video1	“INTAX S COUNSEL” 公司举办2025年商务会议	html	{"html":"<div data-youtube-video=\\"\\"><iframe width=\\"640\\" height=\\"480\\" allowfullscreen=\\"true\\" autoplay=\\"false\\" disablekbcontrols=\\"false\\" enableiframeapi=\\"false\\" endtime=\\"0\\" ivloadpolicy=\\"0\\" loop=\\"false\\" modestbranding=\\"false\\" origin=\\"\\" playlist=\\"\\" rel=\\"1\\" src=\\"https:\\/\\/www.youtube-nocookie.com\\/embed\\/Imxij7NLHT4?si=3nmvTCSYobPARyCb\\" start=\\"0\\"><\\/iframe><\\/div><p><\\/p>"}	sidebar	1	t	2025-12-15 18:04:44	2025-12-15 18:04:44
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 1, true);


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 6, true);


--
-- Name: company_histories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.company_histories_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: media_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.media_id_seq', 19, true);


--
-- Name: menu_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_items_id_seq', 9, true);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 3, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 31, true);


--
-- Name: page_sections_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.page_sections_id_seq', 2, true);


--
-- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pages_id_seq', 2, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 14, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: posts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.posts_id_seq', 4, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 5, true);


--
-- Name: service_sections_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.service_sections_id_seq', 1, false);


--
-- Name: service_widgets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.service_widgets_id_seq', 1, false);


--
-- Name: services_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.services_id_seq', 8, true);


--
-- Name: settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settings_id_seq', 18, true);


--
-- Name: sliders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sliders_id_seq', 2, true);


--
-- Name: team_members_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.team_members_id_seq', 5, true);


--
-- Name: testimonials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.testimonials_id_seq', 8, true);


--
-- Name: translations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.translations_id_seq', 200, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- Name: widgets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.widgets_id_seq', 2, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: clients clients_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_slug_unique UNIQUE (slug);


--
-- Name: company_histories company_histories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_histories
    ADD CONSTRAINT company_histories_pkey PRIMARY KEY (id);


--
-- Name: company_histories company_histories_year_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_histories
    ADD CONSTRAINT company_histories_year_unique UNIQUE (year);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: media media_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_pkey PRIMARY KEY (id);


--
-- Name: menu_items menu_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_items
    ADD CONSTRAINT menu_items_pkey PRIMARY KEY (id);


--
-- Name: menus menus_location_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_location_unique UNIQUE (location);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: page_sections page_sections_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_sections
    ADD CONSTRAINT page_sections_pkey PRIMARY KEY (id);


--
-- Name: pages pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);


--
-- Name: pages pages_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_slug_unique UNIQUE (slug);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permission_role permission_role_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: permissions permissions_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_unique UNIQUE (name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_slug_unique UNIQUE (slug);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: posts posts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_pkey PRIMARY KEY (id);


--
-- Name: posts posts_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_slug_unique UNIQUE (slug);


--
-- Name: role_user role_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_pkey PRIMARY KEY (role_id, user_id);


--
-- Name: roles roles_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_unique UNIQUE (name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: roles roles_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_slug_unique UNIQUE (slug);


--
-- Name: service_sections service_sections_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_sections
    ADD CONSTRAINT service_sections_pkey PRIMARY KEY (id);


--
-- Name: service_widgets service_widgets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_widgets
    ADD CONSTRAINT service_widgets_pkey PRIMARY KEY (id);


--
-- Name: services services_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_pkey PRIMARY KEY (id);


--
-- Name: services services_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_slug_unique UNIQUE (slug);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: settings settings_key_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_key_unique UNIQUE (key);


--
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (id);


--
-- Name: sliders sliders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sliders
    ADD CONSTRAINT sliders_pkey PRIMARY KEY (id);


--
-- Name: team_members team_members_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_members
    ADD CONSTRAINT team_members_pkey PRIMARY KEY (id);


--
-- Name: team_members team_members_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_members
    ADD CONSTRAINT team_members_slug_unique UNIQUE (slug);


--
-- Name: testimonials testimonials_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_pkey PRIMARY KEY (id);


--
-- Name: translations translations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_pkey PRIMARY KEY (id);


--
-- Name: translations translations_translatable_type_translatable_id_locale_field_uni; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_translatable_type_translatable_id_locale_field_uni UNIQUE (translatable_type, translatable_id, locale, field);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: widgets widgets_key_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.widgets
    ADD CONSTRAINT widgets_key_unique UNIQUE (key);


--
-- Name: widgets widgets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.widgets
    ADD CONSTRAINT widgets_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: menu_items_linkable_id_linkable_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menu_items_linkable_id_linkable_type_index ON public.menu_items USING btree (linkable_id, linkable_type);


--
-- Name: menu_items_menu_id_parent_id_order_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menu_items_menu_id_parent_id_order_index ON public.menu_items USING btree (menu_id, parent_id, "order");


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: translations_translatable_type_translatable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX translations_translatable_type_translatable_id_index ON public.translations USING btree (translatable_type, translatable_id);


--
-- Name: translations_translatable_type_translatable_id_locale_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX translations_translatable_type_translatable_id_locale_index ON public.translations USING btree (translatable_type, translatable_id, locale);


--
-- Name: categories categories_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: clients clients_logo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_logo_id_foreign FOREIGN KEY (logo_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: company_histories company_histories_image_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_histories
    ADD CONSTRAINT company_histories_image_id_foreign FOREIGN KEY (image_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: media media_uploaded_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_uploaded_by_foreign FOREIGN KEY (uploaded_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: menu_items menu_items_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_items
    ADD CONSTRAINT menu_items_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: menu_items menu_items_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_items
    ADD CONSTRAINT menu_items_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.menu_items(id) ON DELETE CASCADE;


--
-- Name: page_sections page_sections_page_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_sections
    ADD CONSTRAINT page_sections_page_id_foreign FOREIGN KEY (page_id) REFERENCES public.pages(id) ON DELETE CASCADE;


--
-- Name: pages pages_author_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_author_id_foreign FOREIGN KEY (author_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: pages pages_header_image_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_header_image_id_foreign FOREIGN KEY (header_image_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: permission_role permission_role_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: permission_role permission_role_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: posts posts_author_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_author_id_foreign FOREIGN KEY (author_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: posts posts_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- Name: posts posts_featured_image_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_featured_image_id_foreign FOREIGN KEY (featured_image_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: role_user role_user_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: role_user role_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: service_sections service_sections_service_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_sections
    ADD CONSTRAINT service_sections_service_id_foreign FOREIGN KEY (service_id) REFERENCES public.services(id) ON DELETE CASCADE;


--
-- Name: service_widgets service_widgets_service_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_widgets
    ADD CONSTRAINT service_widgets_service_id_foreign FOREIGN KEY (service_id) REFERENCES public.services(id) ON DELETE CASCADE;


--
-- Name: service_widgets service_widgets_widget_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.service_widgets
    ADD CONSTRAINT service_widgets_widget_id_foreign FOREIGN KEY (widget_id) REFERENCES public.widgets(id) ON DELETE CASCADE;


--
-- Name: services services_featured_image_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_featured_image_id_foreign FOREIGN KEY (featured_image_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: sliders sliders_image_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sliders
    ADD CONSTRAINT sliders_image_id_foreign FOREIGN KEY (image_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: team_members team_members_photo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_members
    ADD CONSTRAINT team_members_photo_id_foreign FOREIGN KEY (photo_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- Name: testimonials testimonials_client_photo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_client_photo_id_foreign FOREIGN KEY (client_photo_id) REFERENCES public.media(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

\unrestrict FyIcQabJ2RF4piAc9Up7f3kh9zzewcg3dO0lwHtbfCu7u0IbFF0FpddtgcpQL6V

