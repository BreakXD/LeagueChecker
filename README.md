
# League of Legends Account Checker

## Introduction (EN)
This system checks information of League of Legends accounts. It can be used via CLI or through a web interface.

## Prerequisites
- PHP installed on the server.
- Internet access for interaction with Riot Games APIs.

## Configuration
Clone the repository or download the files to a PHP server.

## Usage

### Via CLI
1. Open `api.php`.
2. Enter the League of Legends account's username and password in the designated variables.
3. Run the script in the terminal with `php api.php`.
4. Account information will be processed and displayed.

### Via Browser
1. Open `index.html` in a browser.
2. Enter account information in the format `username:password` in the combobox.
3. Click on "Test".
4. Information will be processed and displayed in the web interface.

## Usage as an Independent API
1. Make GET requests to `api.php` with `user` and `pass` parameters.
   Example: `http://yourserver.com/api.php?user=username&pass=password`.
2. The API will process the information and return the account data.

## Available Information
The system returns various account information, including:
- Username and old nickname.
- Riot ID and change status available.
- Email (partially masked).
- Account level.
- Leavebuster status.
- Account creation date.
- Ranking data (SoloQ and Flex), including last season's ranking, win rate, and LP (for Master tier and above).
- Date and inactivity since the last game.
- Skin and champion count.
- Blue Essence (BE) and Riot Points (RP).
- Quantity of gems, chests, and keys.
- Details of the first champions and skins acquired.

---

## Introdução (PT-BR)
Este sistema verifica informações de contas do League of Legends. Pode ser utilizado via CLI ou através de uma interface web.

## Pré-requisitos
- PHP instalado no servidor.
- Acesso à internet para interação com as APIs da Riot Games.

## Configuração
Clone o repositório ou baixe os arquivos em um servidor com PHP.

## Uso

### Via CLI
1. Abra `api.php`.
2. Insira o nome de usuário e senha da conta de League of Legends nas variáveis designadas.
3. Execute o script no terminal com `php api.php`.
4. As informações da conta serão processadas e exibidas.

### Via Navegador
1. Abra `index.html` em um navegador.
2. Insira as informações da conta no formato `usuário:senha` na combobox.
3. Clique em "Testar".
4. As informações serão processadas e exibidas na interface web.

## Uso como API Independente
1. Faça requisições GET para `api.php` com parâmetros `user` e `pass`.
   Exemplo: `http://seuservidor.com/api.php?user=nomeDoUsuario&pass=senha`.
2. A API processará as informações e retornará os dados da conta.

## Informações Disponíveis
O sistema retorna várias informações da conta, incluindo:
- Nome de usuário e apelido antigo.
- ID da Riot e status de mudança disponível.
- E-mail (parcialmente mascarado).
- Nível da conta.
- Status de leavebuster.
- Data de criação da conta.
- Dados de classificação (SoloQ e Flex), incluindo a classificação da temporada anterior, taxa de vitória e PDL (para Mestre e acima).
- Data e inatividade desde o último jogo.
- Contagem de skins e campeões.
- Essência Azul (BE) e Riot Points (RP).
- Quantidade de gemas, baús e chaves.
- Detalhes dos primeiros campeões e skins adquiridos.

---

