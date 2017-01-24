{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_header_javascript_jquery' append}
    {*<script src="{link file='frontend/_public/src/js/tl_premium_users.js'}"></script>*}
    <script>$(document).ready(function() {
            // jquery to get JSON from the forismatic API
            var  quoteUrl = "http://api.forismatic.com/api/1.0/?method=getQuote&key=457653&format=jsonp&lang=en&jsonp=?";
            var getQuote = function(data) {
                $(".quote").text(data.quoteText);
                if (data.quoteAuthor == "")
                    data.quoteAuthor = "Unknown";

                $(".author").text("-" + " " + data.quoteAuthor);
            };
                $.getJSON(quoteUrl, getQuote);
            });
    </script>
{/block}

{block name="frontend_index_navigation_categories_top_include" prepend}
{*<script src="/shopware/engine/Shopware/Plugins/Local/Frontend/PremiumUserPlugin/Views/frontend/_public/src/js/repertus-pos-loadingmask.js"></script>*}

    <style>
        .quote-box {
            width:100%;
            text-align:center;
        }
        .quote {
            {if $italic}font-style:italic;{/if}
            font-size:{$fontSize}px;
        }
    </style>


    <div class="quote-box">
        <span class="quote"></span>
        <span class="author"></span>
    </div>
{/block}