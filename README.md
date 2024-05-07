# Utility Hub

Utility Hub é uma plataforma que oferece serviços úteis para simplificar tarefas do dia a dia.

## Recursos

- **Conversor de Unidades:** Converta facilmente entre diferentes unidades de medida, como temperatura, comprimento, peso e muito mais.
- **Gerador de Senhas:** Crie senhas seguras e aleatórias com opções personalizáveis para atender às suas necessidades de segurança.
- **Gerador de Números Aleatórios:** Gere números aleatórios dentro de intervalos específicos para várias aplicações.
- **Outros Serviços Úteis:** Nossa API está em constante evolução, e estamos adicionando novos serviços úteis regularmente.

## Uso

Para começar a usar a Utility Hub, siga estas etapas simples:

1. Faça o login para acessar a aplicação.
2. Registre-se se você ainda não tiver uma conta.
3. Explore os serviços disponíveis e escolha o que melhor atende às suas necessidades.
4. Use o formulário fornecido para inserir os dados necessários para o serviço selecionado.
5. Visualize os resultados e use as informações geradas conforme necessário.

## Como instalar

Para instalar o projeto, siga as etapas a seguir:

1. Baixe o projeto (via .zip/rar ou github).
2. Adicione o projeto ao seu servidor web (apache).
   1. Caso seja ambiente de desenvolvimento, adicione um DNS na pasta host, ex.: ```127.0.0.1   utilityhub.dev.com.br```. Assim o servidor apache irá redirecionar de forma correta as rotas
   2. Caso seja ambiente de produção, basta apontar o DNS para a pasta raiz do projeto.
3. Crie a base de dados MySql.
4. Crie e configure o arquivo .env com as informações do banco de dados conforme o exemplo.