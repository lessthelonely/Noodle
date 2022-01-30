CREATE SCHEMA IF NOT EXISTS lbaw2152;

SET search_path TO lbaw2152;

DROP TABLE IF EXISTS gosto CASCADE;
DROP TABLE IF EXISTS grupoUtilizador CASCADE;
DROP TABLE IF EXISTS grupoPublicacao CASCADE;
DROP TABLE IF EXISTS grupo CASCADE;
DROP TABLE IF EXISTS moderador CASCADE;
DROP TABLE IF EXISTS comentario CASCADE;
DROP TABLE IF EXISTS notificacaoUtilizador CASCADE;
DROP TABLE IF EXISTS notificacao CASCADE;
DROP TABLE IF EXISTS publicacao CASCADE;
DROP TABLE IF EXISTS administrador CASCADE;
DROP TABLE IF EXISTS colega CASCADE;
DROP TABLE IF EXISTS utilizadorDocente CASCADE;
DROP TABLE IF EXISTS utilizadorEstudante CASCADE;
DROP TABLE IF EXISTS utilizador CASCADE;

DROP TYPE IF EXISTS tipoAnexo CASCADE;
DROP TYPE IF EXISTS privacidade CASCADE;
DROP TYPE IF EXISTS tipoGrupo CASCADE;
DROP TYPE IF EXISTS tipoNotificacao CASCADE;

CREATE TYPE tipoAnexo AS ENUM ('mp3', 'photo', 'document');
CREATE TYPE privacidade AS ENUM ('public', 'private');
CREATE TYPE tipoGrupo AS ENUM ('lazer', 'work');
CREATE TYPE tipoNotificacao AS ENUM ('like', 'comment', 'post');

CREATE TABLE utilizador (
    id serial PRIMARY KEY,
    nome text,
    email text NOT NULL UNIQUE,
    password text NOT NULL,
    dataNascimento timestamp CONSTRAINT notBornYesterday CHECK (dataNascimento <now()::timestamp),
    dataTempoRegisto timestamp CONSTRAINT notRegisteredYesterday CHECK (dataTempoRegisto > dataNascimento),
    atualizado timestamp,
    instituicaoEnsino text,
    privacidade privacidade NOT NULL,
    fotoPerfil text,
    is_blocked boolean,
    fotoHeader text
);

CREATE TABLE utilizadorEstudante (
    id serial PRIMARY KEY REFERENCES utilizador ON DELETE CASCADE ON UPDATE CASCADE,
    curso text, 
    anoCorrente integer,
    media float
);

CREATE TABLE utilizadorDocente (
    id serial PRIMARY KEY REFERENCES utilizador ON DELETE CASCADE ON UPDATE CASCADE,
    departamento text, 
    formacao text
);

CREATE TABLE grupo (
    id serial PRIMARY KEY,
    nome text,
    dataTempoCriacao timestamp,
    atualizado timestamp,
    privacidade privacidade NOT NULL,
    tipo tipoGrupo NOT NULL,
    CONSTRAINT notCreatedYesterday CHECK (dataTempoCriacao <= now()::timestamp)
);

CREATE TABLE moderador (
    idGrupo integer NOT NULL REFERENCES grupo (id) ON DELETE CASCADE ON UPDATE CASCADE,
    idUtilizador integer NOT NULL REFERENCES utilizador (id)  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (idGrupo, idUtilizador)
);

CREATE TABLE administrador (
    id serial PRIMARY KEY,
    email text UNIQUE NOT NULL,
    password text NOT NULL,
    idDocente integer REFERENCES utilizadorDocente(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE grupoUtilizador (
    idUtilizador integer NOT NULL REFERENCES utilizador (id) ON DELETE CASCADE ON UPDATE CASCADE,
    idGrupo integer NOT NULL REFERENCES grupo (id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (idUtilizador, idGrupo)
);

CREATE TABLE notificacao (
    id serial PRIMARY KEY,
    dataTempo timestamp,
    atualizado timestamp,
    tipo tipoNotificacao NOT NULL,
    CONSTRAINT notNotifiedYesterday CHECK (dataTempo <= now()::timestamp)
);

CREATE TABLE publicacao (
    id serial PRIMARY KEY,
    dataTempo timestamp CONSTRAINT notPostedYesterday CHECK (dataTempo <= now()::timestamp),
    numeroGostos integer,
    atualizado timestamp,
    numeroComentarios integer,
    conteudo text,
    anexo text,
    idNotificacao integer REFERENCES notificacao(id) ON DELETE CASCADE ON UPDATE CASCADE,
    idUtilizador integer REFERENCES utilizador(id) ON DELETE CASCADE ON UPDATE CASCADE,
    tipoAnexo tipoAnexo,
    privacidade privacidade NOT NULL,
    CONSTRAINT positiveLikes CHECK (numeroGostos >= 0),
    CONSTRAINT positiveComments CHECK (numeroComentarios >= 0)
);

CREATE TABLE gosto (
    id serial PRIMARY KEY,
    idNotificacao integer REFERENCES notificacao(id) ON DELETE CASCADE ON UPDATE CASCADE,
    idUtilizador integer REFERENCES utilizador(id) ON DELETE CASCADE ON UPDATE CASCADE,
    idPublicacao integer REFERENCES publicacao(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comentario (
    id serial PRIMARY KEY,
    dataTempo timestamp,
    atualizado timestamp,
    conteudo text,
    idNotificacao integer REFERENCES notificacao(id) ON DELETE CASCADE ON UPDATE CASCADE,
    idUtilizador integer REFERENCES utilizador(id) ON DELETE CASCADE ON UPDATE CASCADE,
    idPublicacao integer REFERENCES publicacao(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT notCommentedYesterday CHECK (dataTempo <= now()::timestamp)
);

CREATE TABLE notificacaoUtilizador (
    id serial PRIMARY KEY,
    idUtilizador integer NOT NULL REFERENCES utilizador (id) ON DELETE CASCADE ON UPDATE CASCADE,
    idNotificacao integer REFERENCES notificacao (id) ON DELETE CASCADE ON UPDATE CASCADE,
    vista boolean NOT NULL,
    UNIQUE (idUtilizador, idNotificacao)
);

CREATE TABLE grupoPublicacao (
    idGrupo integer REFERENCES grupo (id) ON DELETE CASCADE ON UPDATE CASCADE,
    idPublicacao integer PRIMARY KEY REFERENCES publicacao (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE colega (
    utilizador1 integer REFERENCES utilizador(id) ON DELETE CASCADE ON UPDATE CASCADE,
    utilizador2 integer REFERENCES utilizador(id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (utilizador1, utilizador2)
);

--INDEXES PERFORMANCE
DROP INDEX IF EXISTS public_posts CASCADE;
DROP INDEX IF EXISTS group_posts CASCADE;
DROP INDEX IF EXISTS user_posts CASCADE;
DROP INDEX IF EXISTS search_user CASCADE;
DROP INDEX IF EXISTS search_group CASCADE;
DROP INDEX IF EXISTS search_post CASCADE;

--IDX01
CREATE INDEX public_posts 
ON publicacao(privacidade) 
WHERE privacidade = 'public';

--IDX02
--CREATE INDEX group_posts 
--ON grupoPublicacao 
--USING GIN (idGrupo);

--IDX03
CREATE INDEX user_posts
ON publicacao 
USING btree (idUtilizador);

--INDEXES FULL-TEXT SEARCH
--IDX11
ALTER TABLE utilizador
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION utilizador_search_update()
RETURNS TRIGGER AS $$
BEGIN 
 IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.nome),'A'));
 END IF;
 
 IF TG_OP = 'UPDATE' THEN 
    IF (NEW.nome <> OLD.nome) THEN 
        NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.nome),'A'));
    END IF;
 END IF;
 RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER utilizador_search_update
BEFORE INSERT OR UPDATE ON utilizador
FOR EACH ROW
EXECUTE PROCEDURE utilizador_search_update();

CREATE INDEX search_user 
ON utilizador 
USING GIN(tsvectors);

--IDX12
ALTER TABLE grupo
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION grupo_search_update()
RETURNS TRIGGER AS $$
BEGIN 
 IF TG_OP = 'INSERT' THEN NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.nome),'A'));
 END IF;
 
 IF TG_OP = 'UPDATE' THEN
    IF (NEW.nome <> OLD.nome) THEN 
        NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.nome),'A'));
    END IF;
 END IF;
 RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER grupo_search_update
BEFORE INSERT OR UPDATE ON grupo
FOR EACH ROW 
EXECUTE PROCEDURE grupo_search_update();

CREATE INDEX search_group 
ON grupo 
USING GIN(tsvectors);

--IDX13
ALTER TABLE publicacao
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION post_search_update()
RETURNS TRIGGER AS $$
BEGIN 
  IF TG_OP = 'INSERT' THEN NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.conteudo),'A')); 
  END IF; 
  
  IF TG_OP = 'UPDATE' THEN 
    IF (NEW.conteudo <> OLD.conteudo) THEN 
        NEW.tsvectors = (setweight(to_tsvector('portuguese',NEW.conteudo),'A'));
    END IF;
  END IF;
  RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER post_search_update
BEFORE INSERT OR UPDATE ON publicacao
FOR EACH ROW 
EXECUTE PROCEDURE post_search_update();

CREATE INDEX search_post 
ON publicacao 
USING GiST(tsvectors);

--TRIGGERS
--TRIGGER01
DROP TRIGGER IF EXISTS num_likes ON gosto CASCADE;
CREATE FUNCTION num_likes() 
RETURNS TRIGGER AS 
$$ 
BEGIN
    UPDATE publicacao
    SET 
      numeroGostos = coalesce(publicacao.numeroGostos, 0) + 1
    WHERE id = new.id;
    
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER num_likes 
        AFTER INSERT ON gosto
        FOR EACH ROW
        EXECUTE PROCEDURE num_likes();

--TRIGGER02
DROP TRIGGER IF EXISTS num_comments ON comentario CASCADE;
CREATE FUNCTION num_comments()
RETURNS TRIGGER AS 
$$ 
BEGIN
    UPDATE publicacao
    SET 
      numeroComentarios = coalesce(publicacao.numeroComentarios, 0) + 1
    WHERE id = new.id;

    RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER num_comments
       AFTER INSERT ON comentario
       FOR EACH ROW
       EXECUTE PROCEDURE num_comments();

--TRIGGER03
DROP TRIGGER IF EXISTS not_comments ON comentario CASCADE;
CREATE FUNCTION not_comments()
RETURNS TRIGGER AS 
$$ 
DECLARE
    n_id integer;
    id_u integer;
    
BEGIN
  INSERT INTO notificacao(tipo, dataTempo) values('comment',now()) RETURNING id INTO n_id;
  
  SELECT idUtilizador 
  INTO id_u
  FROM publicacao
  WHERE id = NEW.idPublicacao;
  
  INSERT INTO notificacaoUtilizador(idNotificacao, idUtilizador,vista) values (n_id, id_u, 'False');
  RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER not_comments 
       AFTER INSERT ON comentario
       FOR EACH ROW
       EXECUTE PROCEDURE not_comments();

--TRIGGER04
DROP TRIGGER IF EXISTS not_likes ON gosto CASCADE;
CREATE FUNCTION not_likes()
RETURNS TRIGGER AS
$$ 
DECLARE
  n_id integer;
  id_u integer;
  
BEGIN
    INSERT INTO notificacao(tipo, dataTempo) values('like',now()) RETURNING id INTO n_id;
    
    SELECT idUtilizador 
    INTO id_u
    FROM publicacao 
    WHERE id = NEW.idPublicacao;
    
    INSERT INTO notificacaoUtilizador(idNotificacao, idUtilizador, vista) values (n_id, id_u, 'False');
    RETURN NEW;

END;
$$
LANGUAGE plpgsql;

--TRIGGER05
DROP TRIGGER IF EXISTS not_grupo ON grupoPublicacao CASCADE;
CREATE FUNCTION not_grupo()
RETURNS TRIGGER AS 
$$ 
DECLARE
    arrow record; 
    n_id integer;
	id_u integer;
    g_id integer;
BEGIN
    INSERT INTO notificacao(tipo, dataTempo) values('post',now()) RETURNING id INTO n_id;
    
    SELECT idUtilizador 
    INTO id_u
    FROM publicacao 
    WHERE id = NEW.idPublicacao;

    SELECT idGrupo
    INTO g_id
    FROM grupoUtilizador
    WHERE idUtilizador = id_u;
    
    FOR arrow IN (SELECT idUtilizador FROM grupoUtilizador) LOOP
        IF arrow.idUtilizador <> id_u AND arrow.idGrupo = g_id THEN 
            INSERT INTO notificacaoUtilizador(idNotificacao, idUtilizador) values (n_id, arrow.idUtilizador);
        END IF; 
    END LOOP;  
    RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER not_grupo
    AFTER INSERT ON grupoPublicacao
    FOR EACH ROW
    EXECUTE PROCEDURE not_grupo();

--TRIGGER06
DROP TRIGGER IF EXISTS num_moderadores ON moderador CASCADE;
CREATE FUNCTION num_moderadores()
RETURNS TRIGGER AS 
$$ 
DECLARE
    n_id integer;
    id_u integer;
    arrow record;
    id_alreadyhere integer;
    counter integer;
	g_t text;
    
BEGIN
    FOR arrow IN (SELECT idGrupo FROM moderador) LOOP 
        IF arrow.idGrupo = new.idGrupo THEN
            counter:=counter+1;
        END IF;
    END LOOP;
    
    IF counter = 2 THEN 
        RAISE EXCEPTION 'Este grupo já tem dois moderadores, não é possível adicionar mais.' ;
    END IF;
    
    IF counter = 1 THEN 
        SELECT tipo
        INTO g_t
        FROM grupo
        WHERE id = new.idGrupo;
        
        IF g_t = 'TRABALHO' THEN 
            FOR arrow IN (SELECT idGrupo FROM moderador) LOOP
                IF arrow.idGrupo = new.idGrupo THEN
                    id_alreadyhere := arrow.idUtilizador;
                END IF;
            END LOOP;
            
            IF EXISTS (SELECT id FROM utilizadorEstudante WHERE id = id_alreadyhere) AND EXISTS (SELECT id FROM utilizadorEstudante WHERE id = new.idUtilizador) THEN
               RAISE EXCEPTION 'Este grupo já tem um moderador estudante, precisa de um moderador docente.'; 
            END IF;
        
            IF EXISTS (SELECT id FROM utilizadorDocente WHERE id = id_alreadyhere) AND EXISTS (SELECT id FROM utilizadorDocente WHERE id = new.idUtilizador) THEN
                RAISE EXCEPTION 'Este grupo já tem um moderador docente, precisa de um moderador estudante.' ; 
            END IF;
        END IF; 
    END IF;
    RETURN NEW;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER num_moderadores
       BEFORE INSERT ON moderador
       FOR EACH ROW 
       EXECUTE PROCEDURE num_moderadores();

--TRANSACTIONS
--TRAN01
CREATE OR REPLACE PROCEDURE replace_moderador
(
  idU integer,
  new_idU integer
) 
LANGUAGE plpgsql
AS
$$
DECLARE 
  grupo_id integer;
BEGIN
  grupo_id := (SELECT idGrupo FROM moderador WHERE idUtilizador = idU);

--Apagar moderador
DELETE FROM moderador WHERE idUtilizador = idU;

--Adicionar novo moderador
INSERT INTO moderador (idGrupo,idUtilizador) VALUES(grupo_id,new_idU);
END 
$$;

--TRAN02
CREATE OR REPLACE PROCEDURE constant_privacy
(
  idU integer,
  idN integer,
  dT timestamp,
  c text,
  a text,
  tA tipoAnexo,
  idG integer,
  idP integer
)
LANGUAGE plpgsql
AS
$$
DECLARE
   p_t privacidade;
BEGIN
--Antes de inserir em publicação vamos ver como é a privacidade no utilizador
p_t := (SELECT privacidade FROM utilizador
WHERE id=idU);

INSERT INTO publicacao(idNotificacao,privacidade,dataTempo,conteudo,anexo,tipoAnexo,idUtilizador)   VALUES(idN,p_t,dT,c,a,tA,idU);

--Caso seja uma publicação para um grupo, esta fica com a privacidade do grupo
p_t := (SELECT privacidade FROM grupo WHERE id=idG);

UPDATE publicacao
SET 
   privacidade = p_t
WHERE
   id=idP;

INSERT INTO grupoPublicacao(idGrupo,idPublicacao) 
       VALUES(idG,idP);

END 
$$;

--TRAN03
CREATE OR REPLACE PROCEDURE constant_privacy
(
  idU integer,
  idN integer,
  dT timestamp,
  c text,
  a text,
  tA tipoAnexo,
  idG integer,
  idP integer
)
LANGUAGE plpgsql
AS
$$
DECLARE
   p_t privacidade;
BEGIN
--Antes de inserir em publicação vamos ver como é a privacidade no utilizador
p_t := (SELECT privacidade FROM utilizador
WHERE id=idU);

INSERT INTO publicacao(idNotificacao,privacidade,dataTempo,conteudo,anexo,tipoAnexo,idUtilizador)   VALUES(idN,p_t,dT,c,a,tA,idU);

--Caso seja uma publicação para um grupo, esta fica com a privacidade do grupo
p_t := (SELECT privacidade FROM grupo WHERE id=idG);

UPDATE publicacao
SET 
   privacidade = p_t
WHERE
   id=idP;

INSERT INTO grupoPublicacao(idGrupo,idPublicacao) 
       VALUES(idG,idP);

END 
$$;