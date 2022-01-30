# EAP - Especificação da Arquitetura e Protótipo

3 de janeiro de 2022

## Tema Geral

Social Networks

## **Autores**

Cristina Pêra

Luís Soares

Mateus Silva

Melissa Silva

## A7: Especificação de Recursos *Web*

### Visão Global

Nesta secção, apresentamos uma visão global da aplicação *web* a implementar, onde os módulos serão identificados e descritos brevemente.  Os recursos *web* associados a cada módulo são pormenorizados na documentação individual de cada módulo dentro da especificação da *OpenAPI*.

|                 Identificação do Módulo                 |                     Descrição do Módulo                      |
| :-----------------------------------------------------: | :----------------------------------------------------------: |
| **M01: Autenticação de Utilizadores e Administradores** | Recursos *web* associados com as ações de autenticação. Inclui as seguintes funcionalidades do sistema: fazer *login* ou registar-se enquanto Visitante ou fazer *logout* enquanto Utilizador Autenticado e/ou Administradores. |
|                    **M02: Conteúdo**                    | Recursos *web* associados com as ações de criação, gestão e interação com conteúdo. Inclui as seguintes funcionalidades do sistema: criar publicações e comentários, editar publicações e comentários e apagar publicações e comentários; dar/retirar Gostos em publicações e reportar publicações e comentários. |
|                   **M03: Utilizador**                   | Recursos *web* associados com as ações de um Utilizador Autenticado. Inclui as seguintes funcionalidades do sistema: editar o próprio perfil, adicionar colega, apagar a própria conta, criar um grupo, ver as próprias notificações e marcá-las como vistas. |
|                     **M04: Grupos**                     | Recursos *web* associados com as ações de Membros de um Grupo e de Moderador no contexto de um Grupo. Inclui as seguintes funcionalidades do sistema (em relação aos Utilizadores Autenticados): adicionar conteúdo ao grupo,  pedir para aceder a um grupo, sair do grupo. Quanto ao Moderador: adicionar ou retirar membros ao Grupo, adicionar e apagar conteúdo (publicações e comentários), ver e editar definições de Grupo. |
|             **M05: Pesquisa e *Timeline***              | Recursos *web* associados com a funcionalidade de pesquisa do sistema. Inclui as seguintes funcionalidades: pesquisar<sup>*</sup> (pessoas, publicações e grupos) e filtrar resultados (por certos parâmetros). |
|                 **M06: Administração **                 | Recursos *web* associados com a funcionalidade de Administração do sistema. Inclui as seguintes funcionalidades: apagar conteúdo (publicações e comentários), apagar contas (em contexto de banimento) e aplicar sanções a Utilizadores Autenticados. |
|               **M07:  Páginas Estáticas**               | Recursos *web* com conteúdo estático estão associados a este módulo: *FAQ* e *Sobre Nós*. |

<sup>*</sup> Isto inclui o ato de pesquisa (busca de termos) e a visualização dos resultados.

### Permissões

Definiremos nesta secção as permissões utilizadas nos módulos anteriores para estabelecer condições de acesso uniformes a recursos.

| **Identificador** | Designação             | Descrição                      |
| ----------------- | ---------------------- | ------------------------------ |
| **VIS**           | Visitante              | Utilizadores Não Autenticados. |
| **AUT**           | Utilizador Autenticado | Utilizadores Autenticados.     |
| **MOD**           | Moderador              | Administrador de um Grupo.     |
| **ADM**           | Administrador          | Administrador do Sistema.      |



### Especificações *OpenAPI*

```
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW Rede Social Noodle'
  description: 'A7 para o Noodle'

servers:
  - url: http://lbaw2152.lbaw.fe.up.pt

externalDocs:
  description: Mais informação aqui.
  url: https://git.fe.up.pt/lbaw/lbaw2122/lbaw2152/-/wikis/home

tags:
  - name: 'M01: Autenticação de Utilizadores e Administradores'
  - name: 'M02: Conteúdo'
  - name: 'M03: Utilizador'
  - name: 'M04: Grupos'
  - name: 'M05: Pesquisa e Timeline'
  - name: 'M06: Administração'
  - name: 'M07: Páginas Estáticas'

paths:
  /login:
    get:
      operationId: R101
      summary: 'R101: Formulário de Login'
      description: 'Providenciar formulário de login. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '200':
          description: "OK, mostrar UI de Login"
    
    post:
      operationId: R102
      summary: 'R102: Ação de Login'
      description: 'Processa a submissão do formulário de login. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                password:
                  type: string
              required:
                - email
                - password
      responses:
        '302':
          description: 'Redirecionar após processar credenciais de login.'
          headers:
            location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Autenticação bem-sucedida. Redirecionar ao feed personalizado.'
                  value: '/users/{id}'
                302Error:
                  description: 'Autenticação falhada. Redirecionar ao formulário de login.'
                  value: '/login'
    
  /logout:
    get:
      operationId: R103
      summary: 'R103: Ação de Logout'
      description: 'Terminar sessão do utilizador autenticado correntemente. Acesso: AUT'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '302':
          description: 'Redirecionar após processar logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Sucess:
                  description: 'Logout bem-sucedido. Redirecionar ao formulário de login.'
                  value: '/login'
    
  /register:
    get:
      operationId: R104
      summary: 'R104: Formulário de Registo'
      description: 'Providenciar novo formulário de registo de utilizador. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '200':
          description: 'OK. Mostrar UI de Registo.'
      
    post:
      operationId: R105
      summary: 'R105: Ação de Registo'
      description: 'Processar a submissão de um formulário de registo. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'

      requestBody:
        required: true
        content:
          application/x-ww-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                birthdate:
                  type: timestamp
                privacy:
                  type: string
                picture:
                  type: string
                  format: binary
              required:
                - email
                - password
                - nome
                - birthdate
                - privacy
      responses:
          '302':
            description: 'Redirecionamento após procesar a informação do novo utilizador.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Autenticação bem sucedida. Redirecionar ao escolha de tipo de utilizador.'
                    value: '/choose-path'
                  302Failure:
                    description: 'Autenticação falhada. Redirecionar ao formulário de login.'
                    value: '/login'

  /admin/login:
    get:
        operationId: R106
        summary: 'R106: Formulário de Login de Administradores'
        description: 'Providenciar formulário de login. Acesso: VIS'
        tags:
          - 'M01: Autenticação de Utilizadores e Administradores'
        responses:
          '200':
            description: "OK, mostrar UI de Login"
    
    post:
        operationId: R107
        summary: 'R107: Ação de Login de Administradores'
        description: 'Processa a submissão do formulário de login. Acesso: VIS'
        tags:
          - 'M01: Autenticação de Utilizadores e Administradores'
        requestBody:
          required: true
          content:
            application/x-www-form-urlencoded:
              schema:
                type: object
                properties:
                  email:
                    type: string
                  password:
                    type: string
                required:
                  - email
                  - password
        responses:
          '302':
            description: 'Redirecionar após processar credenciais de login.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Autenticação bem-sucedida. Redirecionar ao dashboard.'
                    value: '/admin/admin-users'
                  302Error:
                    description: 'Autenticação falhada. Redirecionar ao formulário de login.'
                    value: '/admin/login'
    
  /admin/logout:
    get:
      operationId: R108
      summary: 'R108: Ação de Logout de Administradores'
      description: 'Terminar sessão do administrador correntemente. Acesso: ADM'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '302':
          description: 'Redirecionar após processar logout.'
          headers:
            location:
              schema:
                type: string
              examples:
                302Sucess:
                  description: 'Logout bem-sucedido. Redirecionar ao formulário de login.'
                  value: '/login'

  /forget-password:
    get:
      operationId: R109
      summary: 'R109: Formulário de Forget Password'
      description: 'Providenciar formulário de esquecimento de password. Acesso VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '200':
          description: "OK, mostrar UI de Forget Password"
    
    post:
      operationId: R110
      summary: 'R110: Ação de Forget Password'
      description: 'Processa a submissão do formulário de forget password. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
              required:
                - email
      responses:
        '302':
          description: 'Aguardar pela receção do email com o token para fazer o reset da password'
    
  /reset-password/{token}:
    get:
      operationId: R111
      summary: 'R111: Formulário de Reset Password'
      description: 'Providenciar formulário de reset password. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      responses:
        '200':
          description: "OK, mostrar UI de Reset Password"

  /reset-password:  
    post:
      operationId: R112
      summary: 'R112: Ação de Reset Password'
      description: 'Processa a submissão do formulário de reset password. Acesso: VIS'
      tags:
        - 'M01: Autenticação de Utilizadores e Administradores'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                password:
                  type: string
              required:
                - email
                - password
      responses:
        '302':
          description: 'Redirecionar após processar credenciais de login.'
          headers:
            location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Reset bem-sucedido. Redirecionar para o formulário de login.'
                  value: '/login'
                302Error:
                  description: 'Autenticação falhada. Tente novamente.'
                  value: '/reset-password'

  /api/post/create:
    post:
      operationId: R201
      summary: 'R201: Criar Publicação'
      description: 'Criar publicação. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                conteudo:
                  type: string
                anexo:
                  type: string
      responses:
        '200':
          description: 'OK. Publicação feita.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     conteudo:
                        type: string
                     anexo:
                        type: string
                   example:
                   - id: 1 
                   - conteudo: O céu é azul
                      
  /api/post/{id}:
    get:
      operationId: R202
      summary: 'R202: Formulário de Edição de Publicação'
      description: 'Providenciar novo formulário de registo de utilizador. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idpublicacao
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Mostrar Formulário de Edição de Publicação.'

    post:
      operationId: R203
      summary: 'R203: Editar Publicação'
      description: 'Editar publicação. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idpublicacao
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                conteudo:
                  type: string
                anexo:
                  type: string
      responses:
        '200':
          description: 'OK. Publicação editada.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     conteudo:
                        type: string
                     anexo:
                        type: string
                   example:
                   - id: 1 
                   - conteudo: O céu é azul
    
    delete:
      operationId: R204
      summary: 'R204: Apagar Publicação'
      description: 'Apagar publicação. Acesso: AUT, MOD, ADM'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Publicação apagada.'

  /api/comment/create/{id}:
    post:
      operationId: R205
      summary: 'R205: Criar Comentário'
      description: 'Criar comentário. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idpublicacao
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                conteudo:
                  type: string
      responses:
        '200':
          description: 'OK. Comentário feito.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     conteudo:
                        type: string
                   example:
                   - id: 1 
                   - conteudo: Menos de 2 meses para estrear 'The Batman'
  
  /api/comment/{id}:
    get:
      operationId: R206
      summary: 'R206: Formulário de Edição de Comentário'
      description: 'Providenciar formulário de edição de comentário. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idcomentario
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: "OK, mostrar UI de Edição de Comentário"

    post:
      operationId: R207
      summary: 'R207: Editar Comentário'
      description: 'Editar comentário. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idcomentario
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                conteudo:
                  type: string
      responses:
        '200':
          description: 'OK. Comentário editado.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     conteudo:
                        type: string
                   example:
                   - id: 1 
                   - conteudo: Quantas horas para o trailer de Moon Knight

    delete:
      operationId: R208
      summary: 'R208: Apagar Comentário'
      description: 'Apagar publicação. Acesso: AUT, MOD, ADM'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idcomentario
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Comentário apagado.'
  
  /api/likes/create-post/{id}:
    post:
      operationId: R209
      summary: 'R209: Criar Gosto em Publicações'
      description: 'Dar gosto em publicações. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idpublicacao
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Gosto feito.'

  /api/likes/create-comment/{id}:
    post:
      operationId: R210
      summary: 'R210: Criar Gosto em Comentários'
      description: 'Dar gosto em comentários. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idcomentario
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Gosto feito.'
  
  /api/likes/delete-post/{id}:
    delete:
      operationId: R211
      summary: 'R211: Apagar Gosto em Publicações'
      description: 'Apagar gosto feito numa publicação. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idpublicacao
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Gosto apagado.'

  /api/likes/delete-comment/{id}:
    delete:
      operationId: R212
      summary: 'R212: Apagar Gosto em Comentários'
      description: 'Apagar gosto feito num comentário. Acesso: AUT'
      tags:
        - 'M02: Conteúdo'
      parameters:
        - in: path
          name: idcomentario
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Gosto apagado.'
  
  /choose-path:
    get:
      operationId: R301
      summary: 'R301: Formulário de Escolha de Tipo de Utilizador'
      description: 'Providenciar novo formulário de escolha de tipo de utilizador. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      responses:
        '200':
          description: 'OK. Mostrar UI de Escolha de tipo de utilizador.'
  
  /user/estudante:
    post:
      operationId: R302
      summary: 'R302: Criação de Utilizador Estudante'
      description: 'Processar a submissão de um formulário de obtenção de dados de um novo utilizador estudante. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      requestBody:
        required: true
        content:
          application/x-ww-form-urlencoded:
            schema:
              type: object
              properties:
                course:
                  type: string
                year:
                  type: integer
                average:
                  type: integer
              required:
                - course
                - year
                - average
      responses:
          '302':
            description: 'Redirecionamento após procesar a informação do novo utilizador estudante.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Criação de tipo de utilizador bem sucedido. Redirecionar para o teu perfil.'
                    value: '/profile/{id}'
                  302Failure:
                    description: 'Criação falhada.'
                    value: '/user/estudante'
  
  /user/docente:
    post:
      operationId: R303
      summary: 'R303: Criação de Utilizador Docente'
      description: 'Processar a submissão de um formulário de obtenção de dados de um novo utilizador docente. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      requestBody:
        required: true
        content:
          application/x-ww-form-urlencoded:
            schema:
              type: object
              properties:
                department:
                  type: string
                formation:
                  type: string
              required:
                - department
                - formation
      responses:
          '302':
            description: 'Redirecionamento após procesar a informação do novo utilizador docente.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Criação de tipo de utilizador bem sucedido. Redirecionar para o teu perfil.'
                    value: '/profile/{id}'
                  302Failure:
                    description: 'Criação falhada'
                    value: '/user/docente'
  
  /profile/{id}:
    get:
      operationId: R304
      summary: 'R304: Ver Perfil de Utilizador'
      description: 'Mostrar um perfil de um utilizador individual. Acesso: AUT, VIS, MOD, ADMIN'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: idutilizador
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Ver UI de perfil de utilizador.'
  
  /config/{id}:
    get:
      operationId: R305
      summary: 'R305: Formulário de Editar Perfil e Definições de Utilizador'
      description: 'Providenciar formulário de edição de perfil e definições de utilizador. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: idutilizador
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Ver formulário de edição.'

    post:
      operationId: R306
      summary: 'R306: Editar Perfil'
      description: 'Editar o próprio perfil individual. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: idutilizador
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                nome:
                  type: string
                birthdate:
                  type: timestamp
                privacidade:
                  type: string
                fotoPerfil:
                  type: string
                fotoHeader:
                  type: string
      responses:
        '200':
          description: 'Alterações guardadas.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     nome:
                        type: string
                     birthdate:
                        type: timestamp
                   example:
                   - id: 1 
                   - nome: Melissa Silva
                   - birthdate: '2001-10-30 00:00:00'
                   - privacidade: 'public'

  /notifications:
    get:
      operationId: R307
      summary: 'R307: Notificações'
      description: 'Lista de Notificações Pessoais. Acesso AUT'
      tags:
        - 'M03: Utilizador'
      responses:
        '200':
          description: "OK, mostrar UI de Notificações"

  /notifications-viewed/{id}:
    post:
      operationId: R308
      summary: 'R308: Notificações Vistas'
      description: 'Marcar Notificações como Vistas. Acesso AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: idnotificação
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Notificação marcada como vista.'
  
  /users/{id}:
    delete:
      operationId: R309
      summary: 'R309: Apagar Conta'
      description: 'Apagar a própria conta. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses: 
        '200':
          description: 'Conta apagada.'

  /users/friends:
    get:
      operationId: R310
      summary: 'R310: Ver lista de colegas'
      description: 'Utilizador deseja ver lista de colegas. Acesso: AUT'
      tags:
       - 'M03: Utilizador'
      responses:
       '200':
         description: 'Ok. Aqui tem a lista de colegas'

  /accept-friend/{id}: 
    post:
      operationId: R311
      summary: 'R311: Aceitar pedido de colega'
      description: 'Utilizador aceita pedido de amizade de um colega, adicionando-o à sua lista de colegas. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Agora são colegas!'

  /reject-friendship-request/{id}: 
    post:
      operationId: R312
      summary: 'R312: Rejeitar pedido de colega'
      description: 'Utilizador rejeita pedido de amizade de um colega. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Rejeitaste este pedido'
  
  /send-friendship-request/{id}: 
    post:
      operationId: R313
      summary: 'R313: Enviar pedido a colega'
      description: 'Utilizador envia pedido de amizade a um colega. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Pedido enviado!'
    
  /breakup/{id}: 
    delete:
      operationId: R314
      summary: 'R314: Terminar relação com colega'
      description: 'Utilizador termina amizade com um dos seus colegas. Acesso: AUT'
      tags:
        - 'M03: Utilizador'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Agora já não são colegas!'
    
  /groups-create-view:
    get:
      operationId: R401
      summary: 'R401: Formulário de Criação de Grupo'
      description: 'Providenciar formulário de criação de grupo. Acesso: AUT'
      tags:
        - 'M04: Grupos'
      responses:
        '200':
          description: "OK, mostrar UI de Criação de Grupo"
  
  /groups-create:
    post:
      operationId: R402
      summary: 'R402: Criar Grupo'
      description: 'Criar um grupo. Acesso: AUT'
      tags:
        - 'M04: Grupos'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                nome:
                  type: string
                privacidade:
                  type: string
                tipo:
                  type: string
                descricao:
                  type: string
                fotoPerfil:
                  type: string
      responses:
        '200':
          description: 'Grupo criado.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     nome:
                        type: string
                     privacidade:
                        type: string
                     tipo:
                        type: string
                     descricao:
                        type: string
                   example:
                   - id: 1 
                   - nome: Projeto de LBAW
                   - privacidade: public
                   - tipo: work
                   - descricao: Este grupo tem como objetivo trabalhar no projeto de LBAW
      
  /groups/{id}:
    get:
      operationId: R403
      summary: 'R403: Visualizar grupo'
      description: 'Mostrar grupo indicado. Acesso: AUT, VIS, MOD, ADMIN'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: idgrupo
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Ver UI de grupo.'

  /group-members/{id}:
    get:
      operationId: R404
      summary: 'R404: Visualizar membros do grupo'
      description: 'Mostrar lista de membros do grupo indicado. Acesso: AUT, VIS, MOD, ADMIN'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: idgrupo
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Ver lista de membros num grupo.'

  /group-delete/{id}:
    delete:
      operationId: R405
      summary: 'R405: Apagar Grupo'
      description: 'Apagar grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Grupo apagado.'

  /group-leave/{id}:
    delete:
      operationId: R406
      summary: 'R406: Sair do Grupo'
      description: 'Um membro decide sair de um grupo a que pertence. Acesso: AUT'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Já não és membro deste grupo.'

  /group-edit/{id}:
    get:
      operationId: R407
      summary: 'R407: Formulário de Editar Grupo'
      description: 'Providenciar formulário de edição de grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: idgrupo
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Ver formulário de edição.'

    post:
      operationId: R408
      summary: 'R408: Editar Grupo'
      description: 'Editar o grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: idgrupo
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                nome:
                  type: string
                descricao:
                  type: string
                tipo:
                  type: string
                privacidade:
                  type: string
                fotoPerfil:
                  type: string
                fotoHeader:
                  type: string
      responses:
        '200':
          description: 'Alterações guardadas.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     nome:
                        type: string
                     privacidade:
                        type: string
                     tipo:
                        type: string
                     descricao:
                        type: string 
                   example:
                   - id: 1 
                   - nome: Projeto LBAW
                   - descricao: Este grupo serve para discutir LBAW
                   - tipo: work
                   - privacidade: 'private'

  /group-view-requests/{id}:
    get:
      operationId: R409
      summary: 'R409: Ver pedidos para  se juntar a um grupo'
      description: 'Moderador de um grupo é capaz de ver todos pedidos de utilizadores para se juntar ao seu grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      responses:
        '200':
          description: 'OK. Mostrar lista de pedidos.'

  /group-ask-to-join/{id}: 
    post:
      operationId: R410
      summary: 'R410: Pedir para se juntar a um grupo'
      description: 'Utilizador pede a moderador de um grupo para o adicionar a este. Acesso: AUT'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Pedido enviado.'
      
  /group/{id}/add/{id_user}:
    post:
      operationId: R411
      summary: 'R411: Aceitar pedido de adesão ao grupo'
      description: 'Moderador aceita pedido de adesão ao seu grupo feito por um utilizador. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: id_user
          schema: 
            type: integer
      responses:
        '200':
          description: 'OK. Pedido aceite, utilizador adicionado  à lista de membros do grupo.'
      
  /group/{id}/reject/{id_user}:
    post:
      operationId: R412
      summary: 'R412: Rejeitar pedido de adesão ao grupo'
      description: 'Moderador rejeita pedido de adesão ao seu grupo feito por um utilizador. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: id_user
          schema: 
            type: integer
      responses:
        '200':
          description: 'OK. Pedido rejeitado.'

  /group/{id}/delete/{id_user}:
    delete:
      operationId: R413
      summary: 'R413: Apagar membro'
      description: 'Moderador apaga um membro do grupo, utilizador em questão deixa de ser membro do grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: id_user
          schema: 
            type: integer
      responses:
        '200':
          description: 'OK. Membro eliminado.'
  
  /group/create-post/{id}:
    post:
      operationId: R414
      summary: 'R414: Criar publicação'
      description: 'Membro de um grupo cria uma publicação no grupo ao qual pertence. Acesso: AUT, MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                conteudo:
                  type: string
                anexo:
                  type: string
      responses:
        '200':
          description: 'OK. Publicação feita.'
          content: 
            application/json:
               schema:
                 type: array
                 items:
                   type: object
                   properties:
                     id:
                       type: integer
                     conteudo:
                        type: string
                     anexo:
                        type: string
                     id_grupo:
                        type: integer
                   example:
                   - id: 1 
                   - conteudo: O céu é azul
                   - id_grupo: 1

  /group/{id}/invite/{id_user}:
    get:
      operationId: R415
      summary: 'R415: Lista de Possíveis Membros'
      description: 'Providenciar lista de utilizadores, com a exceção do moderador aquando a criação de grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      responses:
        '200':
          description: "OK, mostrar UI de Lista de Possíveis Membros"

  /group/{id}/invite/{id_user}:
    post:
      operationId: R416
      summary: 'R416: Enviar convite a utilizador'
      description: 'Moderador envia um convite a um determinado utilizador para que este se junte ao seu grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: id_user
          schema: 
            type: integer
      responses:
        '200':
          description: 'OK. Pedido enviado.'


  /group/accept-invite/{id}:
    post:
      operationId: R417
      summary: 'R417: Aceitar convite'
      description: 'Utilizador aceita um convite para se juntar a um grupo. Passa a ser um dos membros deste. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Pedido aceite, é um membro.'

  /group/reject-invite/{id}:
    post:
      operationId: R418
      summary: 'R418: Rejeitar convite'
      description: 'Utilizador rejeita um convite para se juntar a um grupo. Acesso: MOD'
      tags:
        - 'M04: Grupos'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Pedido rejeitado.'

  /genfeed:
    get:
      operationId: R501
      summary: 'R501: Timeline geral'
      description: 'Visualizar timeline geral. Acesso: AUT, VIS, MOD, ADM'
      tags:
        - 'M05: Pesquisa e Timeline'
      responses:
        '200':
          description: 'OK. Mostrar Timeline geral.'
  
  /fyf:
    get:
      operationId: R502
      summary: 'R502: Timeline Personalizada'
      description: 'Visualizar timeline personalizada. Acesso: AUT'
      tags:
        - 'M05: Pesquisa e Timeline'
      responses:
        '200':
          description: 'OK. Mostrar Timeline Personalizada.'

  /api/search-results-vis:
    get:
      operationId: R503
      summary: 'R503: Pesquisa efetuada por um visitante'
      description: 'Procura de elemento escrito na barra de pesquisa. O elemento é procurado na tabela de utilizadores, publicação, comentário e grupos (sendo que nesta existe uma pesquisa por pesos) e retorna os resultados como JSON. Acesso: VIS'
      tags:
        - 'M05: Pesquisa e Timeline'
      parameters:
        - in: query
          name: query
          description: 'String a usar para pesquisa full-text'
          schema:
            type: string
          required: true
      responses:
        '200':
          description: Sucesso
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    nome_utilizador:
                      type: string
                    conteudo_publicacao:
                      type: string
                    conteudo_comentario:
                      type: string
                    nome_grupo:
                      type: string
                    descricao_grupo:
                      type: string
                example:
                  nome: Projeto de LBAW | 2152
                  descricao: Este projeto é de LBAW

  /api/search-results-aut:
    get:
      operationId: R504
      summary: 'R504: Pesquisa efetuada por um utilizador autenticado ou administrador'
      description: 'Procura de elemento escrito na barra de pesquisa. O elemento é procurado na tabela de utilizadores, publicação, comentário e grupos (sendo que nesta existe uma pesquisa por pesos) e retorna os resultados como JSON. Possível utilizador filtros para diminuir o alvo da pesquisa. Acesso: AUT, ADMIN'
      tags:
        - 'M05: Pesquisa e Timeline'
      parameters:
        - in: query
          name: query
          description: 'String a usar para pesquisa full-text'
          schema:
            type: string
          required: true
        - in: query
          name: user-filter
          description: 'Filtro por utilizador - pesquisa apenas conteúdo feito por este utilizador ou grupos que este faça parte de'
          schema:
            type: string
          required:  false
        - in: query
          name: group-filter
          description: 'Filtro da pesquisa para grupos (pelo título e conteúdo, pesquisa feita por pesos)'
          schema:
            type: boolean
          required: false
        - in: query
          name: post-filter
          description: 'Filtro da pesquisa por publicações.'
          schema:
            type: boolean
          required: false
        - in: query
          name: comment-filter
          description: 'Filtro da pesquisa por comentários.'
          schema:
            type: boolean
          required: false
      responses:
        '200':
          description: Sucesso
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    nome_utilizador:
                      type: string
                    conteudo_publicacao:
                      type: string
                    conteudo_comentario:
                      type: string
                    nome_grupo:
                      type: string
                    descricao_grupo:
                      type: string
                example:
                  nome: Projeto de LBAW | 2152
                  descricao: Este projeto é de LBAW

  /admin/admin-users:
    get:
      operationId: R601
      summary: 'R601: Visualização de Todos os Utilizadores'
      description: 'Visualizar uma lista de todos os utilizadores existentes na plataforma. Acesso: ADM'
      tags:
        - 'M06: Administração'
      responses:
        '200':
          description: 'OK. Ver lista de todos os utilizadores'
          
  /admin/ban-users/{id}:
    post:
      operationId: R602
      summary: 'R602: Banir Utilizador'
      description: 'Banir um utilizador. Acesso: ADMN'
      tags:
        - 'M06: Administração'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Utilizador banido.'

  /admin/unban-users/{id}:
    post:
      operationId: R603
      summary: 'R603: Restabelecer Utilizador'
      description: 'Um utilizador banido tem os seus direitos de volta. Acesso: ADMN'
      tags:
        - 'M06: Administração'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Utilizador restabelecido.'

  /admin/delete-user/{id}:
    post:
      operationId: R604
      summary: 'R604: Apagar Utilizador'
      description: 'Apagar um utilizador. Acesso: ADMN'
      tags:
        - 'M06: Administração'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Utilizador apagado.'

  /about:
    get:
      operationId: R701
      summary: 'R701: Sobre Nós'
      description: 'Visualizar página estática "Sobre Nós". Acesso: AUT, VIS, MOD, ADM'
      tags:
        - 'M07: Páginas Estáticas'
      responses:
        '200':
          description: 'OK'
  
  /faq:
    get:
      operationId: R702
      summary: 'R702: FAQ'
      description: 'Visualizar página estática "FAQ". Acesso: AUT, VIS, MOD, ADM'
      tags:
        - 'M07: Páginas Estáticas'
      responses:
        '200':
          description: 'OK. Mostrar FAQ.'
  
  /contacts:
    get:
      operationId: R703
      summary: 'R703: Contactos'
      description: 'Visualizar página estática "Contactos". Acesso: AUT, VIS, MOD, ADM'
      tags:
        - 'M07: Páginas Estáticas'
      responses:
        '200':
          description: 'OK. Mostrar Contactos.'

  /main-features:
    get:
      operationId: R704
      summary: 'R704: Main Features'
      description: 'Visualizar página estática "Main Features". Acesso: AUT, VIS, MOD, ADM'
      tags:
        - 'M07: Páginas Estáticas'
      responses:
        '200':
          description: 'OK. Mostrar Main Features.'
```

## A8: Protótipo Vertical

Esta secção debruçar-se-á sobre a implementação feita para a entrega da componente **EAP**, da qual faz parte um protótipo vertical com um conjunto de funcionalidades esperadas a serem implementadas.

### Funcionalidades Implementadas

#### Histórias de Utilizador Implementadas

No sistema da plataforma *Noodle*, as histórias de utilizador implementadas estão descritas na seguinte tabela.

| Identificador | Nome                            | Prioridade | Descrição                                                    |
| ------------- | ------------------------------- | ---------- | ------------------------------------------------------------ |
| US01          | Iniciar Sessão                               | Alta       | Enquanto *Visitante*, quero autenticar-me no sistema para aceder a informação privilegiada. |
| US02          | Registar                                     | Alta       | Enquanto *Visitante*, quero registar-me no sistema para permitir autenticação no sistema.   |
| US03          | Ver Página Inicial                           | Alta       | Enquanto *Visitante*, quero poder presenciar um *timeline* de publicações populares que me dêem uma imagem do que é ser um Utilizador Autenticado. |
| US04          | Ver FAQ                                      | Alta       | Enquanto *Visitante*, quero poder aceder à pagina de FAQs que possam esclarecer dúvidas minhas sobre a equipa e funcionamento do site. |
| US05          | Ver Sobre Nós                                | Alta       | Enquanto *Visitante*, desejo poder aceder à página de informação geral sobre a plataforma *Noodle* e os seus criadores. |
| US11          | Terminar sessão                              | Alta       | Enquanto *Utilizador Autenticado*, desejo poder terminar a minha sessão no site para impedir acessos inautorizados. |
| US12          | Ver Página Inicial                           | Alta       | Como *Utilizador Autenticado*, desejo aceder à página inicial, onde se encontra o meu *timeline.* |
| US13          | Ver Aba de Notificações                      | Alta       | Enquanto *Utilizador Autenticado* quero poder ver as notificações para não perder acesso a informação que desejam que chegue a mim. |
| US14          | Ver Definições                               | Alta       | Como *Utilizador Autenticado*, desejo ver a página de definições para proceder a quaisquer alterações necessárias para uma melhor experiência. |
| US15          | Apagar Conta                                 | Alta       | Como *Utilizador Autenticado*, desejo poder agendar a remoção da minha conta caso não pretenda usá-la mais. |
| US16          | Ver Perfil                                   | Alta       | Como *Utilizador Autenticado*, desejo ver o meu próprio perfil, para ver como outros *Utilizadores Autenticados* o vêem. |
| US17          | Editar Perfil                                | Alta       | Como *Utilizador Autenticado*, desejo poder editar o conteúdo do meu perfil a meu gosto. |
| US18          | Fazer Publicação                             | Alta       | Como *Utilizador Autenticado*, desejo poder partilhar informação a partir de publicações próprias. |
| US110         | Editar Publicação                            | Alta       | Como *Utilizador Autenticado*, desejo poder editar uma publicação para corrigir erros que possam comprometer a informação que quero transmitir. |
| US111         | Apagar publicação                            | Alta       | Como *Utilizador Autenticado*, desejo poder apagar publicações feitas por mim. |


#### Recursos *Web* Implementados

No sistema da plataforma *Noodle*, os recursos web implementados estão descritos nas seguintes tabelas.

##### Módulo M01:  Autenticação de Utilizadores e Administradores

| Referência do Recurso *Web* | URL |
| ----------------- | ------------------------------------------------- |
| R101: Formulário de *Login* | GET /login |
| R102: Ação de *Login* | POST /login |
| R103: Ação de *Logout* | GET /logout |
| R104: Formulário de Registo | GET /register |
| R105: Ação de Registo | POST /register |
| R106: Formulário de *Login* de Administradores | GET /admin/login |
| R107: Ação de *Login* de Administradores | POST /admin/login |
| R108: Ação de *Logout* de Administradores | GET /admin/logout |

##### Módulo M02: Conteúdo

| Referência do Recurso *Web*              | URL                   |
| ---------------------------------------- | --------------------- |
| R201: Criar Publicação                   | POST /api/post/create |
| R202: Formulário de Edição de Publicação | GET /api/post/{id}    |
| R203: Editar Publicação                  | POST /api/post/{id}   |
| R204: Apagar Publicação                  | DELETE /api/post/{id} |

##### Módulo M03:  Utilizador

| Referência do Recurso *Web*                                  | URL                  |
| ------------------------------------------------------------ | -------------------- |
| R301: Formulário de Escolha de Tipo de Utilizador            | GET /choose-path     |
| R302: Criação de Utilizador Estudante                        | POST /user/estudante |
| R303: Criação de Utilizador Docente                          | POST /user/docente   |
| R304: Ver Perfil de Utilizador                               | GET /profile/{id}    |
| R305: Formulário de Editar Perfil e Definições de Utilizador | GET /config/{id}     |
| R306: Editar Perfil                                          | POST /config/{id}    |
| R307: Apagar Conta                                           | DELETE /users/{id}   |

##### Módulo M05: Pesquisa e *Timeline*

| Referência do Recurso *Web*    | URL          |
| ------------------------------ | ------------ |
| R501: *Timeline* Geral         | GET /genfeed |
| R502: *Timeline* Personalizada | GET /fyf     |

##### Módulo M06:  Administração

| Referência do Recurso *Web*                 | URL                    |
| ------------------------------------------- | ---------------------- |
| R601: Visualização de Todos os Utilizadores | GET /admin/admin-users |

##### Módulo M07:  Páginas Estáticas

| Referência do Recurso *Web* | URL        |
| --------------------------- | ---------- |
| R701: Sobre Nós             | GET /about |
| R702: FAQ                   | GET /faq   |

### Protótipo

O código do protótipo está disponível em https://git.fe.up.pt/lbaw/lbaw2122/lbaw2152/-/tree/main.

O protótipo vertical está *online* em https://lbaw2152.lbaw.fe.up.pt.

#### ***Credenciais***

-  *Administrador*
  - Email: admin@gmail.com
  - Password: admin

   - *Utilizador Docente*
        - Email: test@gmail.com
        - Password: password
   - *Utilizador Estudante*
        - Email: test2@gmail.com
        - Password: password10



## **Autoavaliação**

Link para a spreadsheet: https://docs.google.com/spreadsheets/d/16L6nAgDa9fuEBVlfhYZxvXK0VGgl8F_wYjcHe1pPU3g/edit#gid=1916533523

### **Histórico de Revisões**

Mudanças feitas à primeira submissão:

1. Eliminação do MOD_DOC e MOD_EST da tabela de Permissões e substituição deste por MOD;
2. Edição do conteúdo acerca do Módulo 4;
3. Adição de mais links à API, que foram implementados na aplicação posteriormente à primeira submissão;
3. Adição de mais links à AP, que correspondem a funcionalidades implementadas posteriormente à última revisão.
