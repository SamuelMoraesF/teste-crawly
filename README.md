# Avaliação técnica

Esta foi uma avaliação técnica bem fácil. A página inicial possui um token CSRF, que é manipulado pelo javascript ao clicar no botão de obter a resposta. O javascript converte alguns caracteres para um padrão pré-estabelecido no código, que consistem em caracteres hexadecimais "escapados" que representam números e letras do alfabeto.

Foram introduzidas algumas técnicas para dificultar o processo, como o nome do arquivo JS que resulta no bloqueio por algumas ferramentas de ad-block, além de acionar o debugger em um loop, para dificultar a análise do código e suas solicitações (tudo isso aliado a ofuscação de código). 

A aplicação foi compreendida de forma fácil, apenas desativando os breakpoints e posteriormente lendo o código JS. Em outros casos, quando realmente não é possível analisar a ferramenta através das ferramenta do desenvolvedor no navegador, pode ser necessário a análise da comunicação via Wireshark com técnicas MITM.

Fiz uma pequena abstração das camadas, que poderia ser melhorada criando uma interface e classes diferentes para cada etapa/solicitação. Poderíamos fazer a mesma coleta de forma mais simples usando algum framework ou linguagem, mas fiz com "PHP puro" para manter o código simples.

Em alguns cenários, talvez seja necessário fazer o uso de instância única (singleton) no cliente HTTP, para manter o estado da sessão/cookies em solicitaçõs diferentes para endpoints distintos.

# Executando

O projeto foi desenvolvido em formato CLI pode ser executado através da imagem docker, que pode ser construída com o comando:

`docker build -t avaliacao-samuel:latest .`

Para executá-lo, basta executar o comando:

`docker run -it --rm avaliacao-samuel:latest start`

E para rodar os testes unitários:

`docker run -it --rm avaliacao-samuel:latest tests`

> De forma a agilizar o processo de verificação da avaliação, incluímos os pacotes de desenvolvimento na imagem padrão do Docker, para evitar a necessidade de fazer duas builds do mesmo projeto. Em ambiente de produção, isso não seria uma boa prática.
