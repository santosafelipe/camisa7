<?php 
    //busca o arquivo e renderiza nesse trecho do código
    include("includes/header.php"); //busca o header dentro da pasta includes
    include("includes/navbar.php"); //busca o menu dentro da pasta includes
?>


    <div class="row">
        <div class="header-text">
            <h1>ANOTHER PLACE <br> FOR SHIRTS</h1>
        </div>
    </div>
</div>

<div class="banner">
    <img src="https://camisa7.netlify.app/images/banner-equipaspt.png" alt="Banner Nova Época, Novos Modelos">
    <div class="custom-banner-texts-container">
        <span class="custom-banner-line">NOVA ÉPOCA</span>
        <span class="custom-banner-line">NOVOS MODELOS</span>
    </div>
</div>

<div class="categories">
    <div class="small-container">
        <div class="row">
            <div class="logos">
                <div class="img-box"><a href="https://www.google.com/search?q=brasileirao" target="_blank" rel="noopener noreferrer"><img src="https://camisa7.netlify.app/images/Brasileirao.png" alt="Logo Brasileirão"></a></div>
            </div>
            <div class="logos">
                <div class="img-box"><a href="https://www.google.com/search?q=liga+portugal" target="_blank" rel="noopener noreferrer"><img src="https://camisa7.netlify.app/images/ligaportugal.png" alt="Logo Liga Portugal"></a></div>
            </div>
            <div class="logos">
                <div class="img-box"><a href="https://www.google.com/search?q=uefa" target="_blank" rel="noopener noreferrer"><img src="https://camisa7.netlify.app/images/UEFA-logo1.png" alt="Logo UEFA"></a></div>
            </div>
            <div class="logos">
                <a href="https://www.google.com/search?q=fifa" target="_blank" rel="noopener noreferrer"><div class="img-box"><img src="https://camisa7.netlify.app/images/fifa-logo.png" alt="Logo FIFA"></div></a>
            </div>
        </div>
    </div>
</div>

<h2 class="title">Novidades</h2>
<section class="promo-cards-container">
    <a class='card novi-card-bg' href='/product?id=porto-ii-new-balance-25/26'>
        <div class="content"><span class="brand-esp">NEW BALANCE</span><h3 class="title-style">PORTO</h3></div>
    </a>
    <a class='card novi-card-bg2' href='/product?id=real-madrid-ii-adidas-25/26'>
        <div class="content"><span class="brand-esp">ADIDAS</span><h3 class="title-style">REAL MADRID</h3></div>
    </a>
    <a class='card novi-card-bg3' href='/product?id=psg-i-nike-25/26'>
        <div class="content"><span class="brand-esp">NIKE</span><h3 class="title-style">PARIS SAINT-GERMAIN</h3></div>
    </a>
</section>

<h2 class="title">Inspire-se</h2>
<section class="promo-cards-container">
    <a class='card ins-card-bg1' href='/product?id=arsenal-i-adidas-25/26'>
        <div class="content"><span class="brand-esp">ADIDAS</span><h3 class="title-style">ARSENAL</h3></div>
    </a>
    <a class='card ins-card-bg2' href='/product?id=borussia-ii-puma-25/26'>
        <div class="content"><span class="brand-esp">PUMA</span><h3 class="title-style">BORUSSIA DORTMUND</h3></div>
    </a>
    <a class='card ins-card-bg3' href='/product?id=portugal-i-puma'>
        <div class="content"><span class="brand-esp">PUMA</span><h3 class="title-style">PORTUGAL</h3></div>
    </a>
</section>

<section class="banner-midf">
    <h2>Explore uma variedade de artigos aqui</h2>
    <a class='bmidf' href='/products'>PRODUTOS</a>
</section>

<h2 class="title">Saldos</h2>
<div class="row">
    <div class="col-4" id="saldos-container">
        </div>
</div>

<h2 class="title">Recomendação</h2>
<div class="row">
    <div class="col-4" id="recomendacao-container">
        </div>
</div>

<?php include("includes/footer.php"); ?>

<div id="cookieConsentBanner" class="cookie-consent-banner">
    <p>Este site utiliza cookies para garantir a melhor experiência de navegação. Ao continuar a usar o site, você concorda com o uso de cookies. Clique <a href='/privacy#politica-privacidade'>aqui</a> para saber mais.</p>
    <button id="acceptCookies" class="cookie-consent-button">Aceitar e Fechar</button>
</div>

<script src="cart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // --- LÓGICA PARA CARREGAR PRODUTOS NA PÁGINA INICIAL ---
    const salesContainer = document.getElementById('saldos-container');
    const recommendedContainer = document.getElementById('recomendacao-container');

    // Função para renderizar os cards de produto
    const renderProducts = (products, container) => {
        if (!container) return;
        container.innerHTML = ''; // Limpa o container
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card-item');

            // A função createProductCardHTML de cart.js já gera todo o HTML completo do card,
            // incluindo preços, link, imagem e o botão "Adicionar ao Carrinho" com seu onclick.
            // Não precisamos recriar partes do HTML aqui.
            productCard.innerHTML = createProductCardHTML(product);

            container.appendChild(productCard);
        });
    };

    // Carregar e filtrar os produtos
    fetch('product.json')
        .then(res => res.json())
        .then(allProducts => {
            const salesProducts = allProducts.filter(p => p.onSale === true);
            const recommendedProducts = allProducts.filter(p => p.isRecommended === true);

            renderProducts(salesProducts, salesContainer);
            renderProducts(recommendedProducts, recommendedContainer);
        })
        .catch(err => {
            console.error("Erro ao carregar produtos na página inicial:", err);
            if(salesContainer) salesContainer.innerHTML = "<p>Erro ao carregar promoções.</p>";
            if(recommendedContainer) recommendedContainer.innerHTML = "<p>Erro ao carregar recomendações.</p>";
        });

    // --- LÓGICA PARA NAVBAR E COOKIES (EXISTENTE) ---
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    const cookieConsentBanner = document.getElementById('cookieConsentBanner');
    const acceptCookiesButton = document.getElementById('acceptCookies');
    const cookieName = 'cookiesAccepted';

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i=0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    if (!getCookie(cookieName)) {
        cookieConsentBanner.classList.add('show');
    }

    acceptCookiesButton.addEventListener('click', () => {
        setCookie(cookieName, 'true', 365);
        cookieConsentBanner.classList.remove('show');
    });
});
</script>

<script src="menu.js"></script> 
    <script>
        // Script para adicionar/remover a classe 'scrolled' do navbar ao rolar a página
        document.addEventListener("DOMContentLoaded", () => {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>
</body>
</html>