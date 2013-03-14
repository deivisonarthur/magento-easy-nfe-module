magento-easy-nfe-module
=======================

Passo a passo para instalação do módulo Magento Easy NFe

Este tutorial foi executado em um Magento 1.7

ATENÇÃO: Você deve fazer um backup completo da sua loja Magento e da base de dados MySQL antes de seguir com este tutorial.

1 - Acesse https://github.com/doitsa/magento-easy-nfe-module

￼

Clique no ícone ZIP￼  para baixar o conteúdo do projeto em um único arquivo .ZIP

Neste momento o seu browser vai iniciar o download do arquivo. Certifique-se que a pasta de destino é conhecida.

Descompacte o arquivo. Uma pasta chamada magento-easy-nfe-module-master será criada com o conteúdo do módulo. O conteúdo desta pasta é o que será movido para a sua loja Magento.

Em nosso exemplo, vamos utilizar uma ferramenta de transferência de arquivos por FTP. Que é cenário mais comum para acesso aos arquivos das lojas Magento em ambiente compartilhado de hosting.

Abra o seu cliente de FTP (em nosso caso, usaremos o FileZilla) e acesse a raiz de sua loja virtual. Em nosso exemplo a raiz é o que ficou do lado direito da tela.
E no lado esquerdo estamos exibindo a pasta que contém o módulo a ser instalado na loja.
=
Para transferir os arquivos, arraste o conteúdo das pastas app e js para a raiz da sua loja Magento.

Você pode fechar seu client de FTP e acessar a área administrativa de sua loja Magento.

No admin da sua loja, limpe o cache do aplicativo pelo menu “System” e depois em Cache Management e então clique no botão:  ￼
[FLUSH MAGENTO CACHE]

Vá então no menu SYSTEM e CONFIGURATION e depois na área EASYNFE (a esquerda, no final da página) clique em NFe.

Atenção: Se neste momento aparecer para você um erro 404, clique me Log Out e entre novamente com seu usuário e senha no admin.


Vamos agora falar das opções do Easy NF-e

- Habilite o módulo na seção  "Geral";
- Preencha com os seus dados principais como UF, Municipio, Modelo Fiscal, e ambiente (Produção ou Homologação);
- Preencha os dados do emitente;
- Configure a seção e-mails para habilitar o envio da Danfe automáticamente por e-mail; 

No box "Acesso" você deve fazer upload do seu certificado digital válido e preencher sua senha.

Chave:  é a chave que foi enviada para o seu email de registro do Easy-NFe
Senha: Senha do Easy-NFe
Import: É o arquivo do certificado digital
Senha do Certificado: É a senha enviada pelo emissor do certificado digital.
￼
No final, não esqueça de clicar em  SAVE CONFIG.￼

Agora vamos ao Catalogo de Produtos em Catalog -> Manage Products
Abra um produto para ter acesso a ficha de edição.

Nesta ficha agora temos no menu a esquerda um ítem chamado NF-e.
Com as seguintes informações:
- NCM;
- Origem da Mercadoria;
- Unidade Comercial;
￼
Veja que todas as informações são obrigatórias para a emissão da Nota Fiscal Eletrônica.
Caso tenha dúvidas sobre o preenchimento, consulte seu contador.

Apartir deste momento sua loja Magento está apta para emitir notas fiscais eletrônicas.

Para testar faça uma compra, e gere a fatura para o pedido no Magento. Neste momento a nota fiscal será gerada.

=
Troubleshooting

Caso tenha problemas na emissão ou tenha dúvidas, entre em contato com suporte@easynfe.com.br

