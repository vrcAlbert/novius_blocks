<script type="text/javascript">
    require(['jquery-nos'], function ($nos) {
        $nos(function () {
            //on récupère la valeur du type pour masquer ou non les chammps voulus
            var $container = $(this);
            var $select_type = $container.find('select[name=bloc_type]');
            var inited = false;

            $select_type.change(function() {
                adapte_form();
            });

            function adapte_form() {
                var type = $select_type.val();
                var $expanders = $container.find('.wrapper_bloc').parent().parent();

                if (type == 'folder') {
                    $expanders.each(function(){
                        $(this).wijexpander({'afterCollapse' : function(){
                            $(this).wijexpander({'allowExpand' : false});
                        }});
                        $(this).wijexpander("collapse");
                    });
                } else {
                    $expanders.each(function(){
                        $(this).wijexpander({'allowExpand' : true});
                        $(this).wijexpander("expand");
                    });
                }
            }
        })
    });
</script>