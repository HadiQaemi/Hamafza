<script>
    $(document).ready(function () {
        $("#TagRes").mCustomScrollbar();
    });
    $(function () {
        $("#KeywordFehresrt").jstree({
            "plugins": ["search"]
        });
        var to = false;
    });
    $('#KeywordFehresrt').jstree({
        "plugins": ["search"],
        'core': {
            'data': [
                @if(isset($keywordTab))
                {!! $keywordTab  !!}
                @endif
            ],
            'rtl': true,
            "themes": {
                "icons": false
            }
        }
    });
    $("#KeywordFehresrt")
        .bind('select_node.jstree',
            function (e, data) {
                var texts = data.node.text;
                var ids = data.node.id;
                $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
                $("#TagRes").animate({
                    scrollTop: 0
                }, 600);
            })
        .on("activate_node.jstree", function (e, data) {
            window.location.href = data.node.a_attr.href;
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });
    $(document).on('shown.bs.modal', function() {
        $("#header").attr('style','position: fixed;width: 100%;z-index: 1;');
    });
    $(document).on('hide.bs.modal', function() {
        $("#header").attr('style','position: fixed;z-index: 10000;width: 100%;');
    });
</script>