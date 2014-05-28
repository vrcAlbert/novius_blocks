<?php

$default_structure = \Arr::filter_recursive($item->blod_structure);

?>
<div class="grid-builder" data-default-structure="<?= htmlspecialchars(\Fuel\Core\Format::forge($default_structure)->to_json()) ?>" data-hidden-field="blod_structure"></div>

<script type="text/javascript">
require(
    [
        'jquery-nos',
        'jquery-ui.draggable',
        'jquery-ui.droppable',
        'jquery-ui.resizable'
    ],
    function($) {

        var $form = $('#<?= $fieldset->form()->get_attribute('id') ?>');

        // Initialize the grids
        $form.find('.grid-builder').each(function() {
            var $grid = $(this);

            // Initialize settings
            var settings = {
                block: {
                    size: 70
                }
            };

            // Initialize the grid
            var $rows = $('<div class="grid-rows"></div>').appendTo($grid);

            // Initialize the save event
            $grid.bind('save', function() {
                var rows = export_grid();
                var field_name = $grid.data('hidden-field');
                if (field_name) {
                    $form.find('input[name="'+field_name+'"]').val(JSON.stringify(rows));
                }
            });

            // Initialize the "Add a new row" button
            $('<a href="#" class="new-row">Créer une nouvelle ligne</a>').on('click', function(e) {
                e.preventDefault();
                add_row();
            }).appendTo($grid);

            // Initialize the default structure
            var default_structure = $grid.data('default-structure') || [];
            if (default_structure.length) {
                $.each(default_structure, function(key, row) {
                    var $row = add_row(row);
                    $.each(row, function(key, column) {
                        var $column = add_column($row, column);
                        if (column.blocks) {
                            $.each(column.blocks, function(key, block) {
                                add_block($column, block);
                            });
                        }
                    });
                });
            }

            /**
             * Exporte la grid (JSON)
             */
            function export_grid() {
                var rows = [];
                $grid.find('.grid-row').each(function() {
                    var columns = [];
                    // Search columns
                    $(this).find('.grid-column').each(function() {
                        var $column = $(this);
                        var blocks = [];
                        // Search blocks
                        $(this).find('.grid-block').each(function() {
                            var $block = $(this);
                            blocks.push({
                                w: $block.width() / settings.block.size,
                                h: $block.height() / settings.block.size
                            });
                        });
                        columns.push({
                            w: $column.width() / settings.block.size,
                            h: $column.height() / settings.block.size,
                            blocks: blocks
                        })
                    });
                    rows.push(columns);
                });
                return rows;
            }

            /**
             * Add a new row
             *
             * @param params
             */
            function add_row(params) {
                var $row = $('<div class="grid-row"></div>').append('<div class="grid-columns"></div>');
                $rows.append($row);
                init_row($row, params);
                return $row;
            }

            /**
             * Add a new column
             *
             * @param $row
             * @param params
             */
            function add_column($row, params) {
                var $columns = $row.find('.grid-columns');
                if (!$columns.length) {
                    return false;
                }
                var $column = $('<div class="grid-column"></div>').append('<div class="grid-blocks"><ul class="sortable"></ul></div>');
                $columns.append($column);
                init_column($column, params);
                return $column;
            }

            /**
             * Add a new block
             *
             * @param $column
             * @param params
             */
            function add_block($column, params) {
                var $sortable = $column.find('.sortable');
                if (!$sortable.length) {
                    return false;
                }
                var $block = $('<li class="ui-state-default grid-block"><span class="block-content">1</span></li>');
                $sortable.append($block);
                $sortable.sortable('refresh');
                init_block($block, params);
                return $block;
            }

            /**
             * Initialize a new row
             *
             * @param $row
             * @param params
             */
            function init_row($row, params) {
                // Add new column
                $actions = $('<div class="actions"></div>').appendTo($row);
                $('<a href="#" class="new-column">Créer une nouvelle colonne</a>').on('click add', function(e) {
                    e.preventDefault();
                    add_column($(this).closest('.grid-row'));
                }).appendTo($actions);
                if (params && params.default_column) {
                    add_column($row, params.default_column);
                }
            }

            /**
             * Initialize a new column
             *
             * @param $column
             * @param params
             */
            function init_column($column, params) {
                // Sortable blocks in column
                var $sortable = $column.find('.sortable');
                $sortable.sortable({
                    connectWith: '.sortable',
                    forcePlaceholderSize: false,
                    tolerance: 'intersect',
                    containment: "parent",
                    distance: 30,
                    stop: function() {
                        // Generate block numbers
                        generate_blocks_numbers();
                        // Save the grid
                        $grid.trigger('save');
                    }
                });
                $sortable.disableSelection();

                // Add new block in column
                $('<div class="actions"></div>')
                    .append(
                        $('<a href="#" class="new-block">+</a>').on('click', function(e) {
                            e.preventDefault();
                            add_block($column);
                        })
                    )
                    .append(
                        $('<a href="#" class="delete-column">x</a>').on('click', function(e) {
                            e.preventDefault();
                            $(this).closest('.grid-column').remove();
                        })
                    )
                    .appendTo($column.find('.grid-blocks'))
                ;

                // Resizable column
                $column.resizable({
                    grid: settings.block.size,
                    stop: function() {
                        // Generate block numbers
                        generate_blocks_numbers();
                        // Save the grid
                        $grid.trigger('save');
                    }
                });

                // Custom height/width
                if (typeof params == 'object') {
                    if (params.w) {
                        $column.css('width', params.w * settings.block.size);
                    }
                    if (params.h) {
                        $column.css('height', params.h * settings.block.size);
                    }
                }
            }

            /**
             * Initialize a new block
             *
             * @param $block
             * @param params
             */
            function init_block($block, params) {
                $block.resizable({
                    grid: settings.block.size,
                    containment: "parent",
                    stop: function() {
                        // Generate block numbers
                        generate_blocks_numbers();
                        // Save the grid
                        $grid.trigger('save');
                    }
                });

                // Delete link
                $('<div class="actions"></div>')
                    .append(
                        $('<a href="" class="delete-block">X</a>').on('click', function(e) {
                            e.preventDefault();
                            $(this).closest('li').remove();
                        })
                    )
                    .appendTo($block)
                ;

                // Custom height/width
                if (typeof params == 'object') {
                    console.log('PARAMS', params);
                    if (params.w) {
                        $block.css('width', params.w * settings.block.size);
                    }
                    if (params.h) {
                        $block.css('height', params.h * settings.block.size);
                    }
                }

                // Generate block numbers
                generate_blocks_numbers();

                // Save the grid
                $grid.trigger('save');
            }

            /**
             * Generates block numbers
             */
            function generate_blocks_numbers() {
                var n = 1;
                $grid.find('.grid-block .block-content').each(function() {
                    $(this).html(n++);
                })
            }
        });
    }
);
</script>

<style type="text/css">
.grid-builder {
    position: relative;
    width: 840px;
    padding: 20px;
}

.grid-builder .sortable {
    list-style-type: none;
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    min-height: 70px;
}

.grid-builder .sortable:after {
    content: '';
    display: block;
    clear: both;
}

.grid-builder .sortable li {
    position: relative;
    margin: 0;
    padding: 0;
    float: left;
    width: 70px;
    height: 70px;
    text-align: center;
    vertical-align: middle;
    text-align: center;
    font-size: 12px;
    line-height: 70px;
    border: 0;
    background: #c6c6c6;
}

.grid-builder .grid-rows {
    margin-bottom: 15px;
}

.grid-builder .grid-row {
    position: relative;
    float: left;
    width: 100%;
    margin: 0 0 35px 0;
    padding: 0;
    background: #ffffff;
    border: 1px dashed #ccc !important;
}

.grid-builder .grid-columns {
    min-height: 70px;
}

.grid-builder .grid-column {
    float: left !important;
    padding: 0;
    max-width: 100%;
    max-height: 100%;
    background: #f2f2f2;
}

.grid-builder .grid-column:before {
    content: '';
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: 0;
    border: 1px solid #fff;
}

.grid-builder .grid-blocks {
    margin: 0;
    min-width: 70px;
    min-height: 70px;
    height: 100%;
}

.grid-builder .grid-block {
    max-width: 100%;
    max-height: 100%;
}

.grid-builder .grid-block .block-content {
    display: block;
    position: absolute;
    width: 100%;
    top: 50%;
    left: 0;
    line-height: 12px;
    margin-top: -6px;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
}

.grid-builder .grid-block:before {
    content: '';
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: 0;
    border: 1px solid #e6e6e6;
}

.grid-builder:after,
.grid-builder .grid-rows:after,
.grid-builder .grid-columns:after {
    content: '';
    display: block;
    clear: both;
}

.grid-builder .actions {
    display: none;
    position: absolute;
    left: 1px;
    top: 1px;
    bottom: auto;
    right: auto;
    text-align: left;
}

.grid-builder .actions a {
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-weight: bold;
    color: white;
    background: #666;
    text-decoration: none;
    padding: 0 5px;
}

.grid-builder .actions a + a {
    margin-left: 1px;
}

.grid-builder .actions .delete-column,
.grid-builder .actions .delete-column:visited {
    color: #ffffff;
    background: red;
}

.grid-builder .actions .delete-block,
.grid-builder .actions .delete-block:visited {
    position: absolute;
    top: 1px;
    right: 1px;
    font-size: 10px;
    font-weight: bold;
    color: white;
    background: red;
}

.grid-builder .grid-row > .actions {
    display: block;
    position: absolute;
    top: auto;
    bottom: -26px;
    left: 0;
    right: auto;
}

.grid-builder .grid-row > .actions a {
    display: inline-block;
    color: white;
    text-decoration: none;
    background: #666;
    font-size: 12px;
    font-weight: normal;
    z-index: 1;
    padding: 3px 10px;
}

.grid-builder .grid-column:hover > .grid-blocks > .actions {
    display: block;
}

.grid-builder .grid-block .actions {
    top: 1px;
    right: 1px;
    left: auto;
    bottom: auto;
    line-height: 22px;
}

.grid-builder .grid-block:hover > .actions {
    display: block;
}

.grid-builder .new-row {
    float: left;
    padding: 3px 10px;
    right: 0;
    bottom: -26px;
    line-height: 20px;
    font-size: 12px;
    font-weight: normal;
    color: white;
    background: #666;
    text-decoration: none;
    z-index: 1;
}

.grid-builder .save {
    float: right;
    padding: 3px 10px;
    bottom: -26px;
    right: 0;
    font-weight: bold;
    color: white;
    background: darkgreen;
    text-decoration: none;
    z-index: 1;
}
</style>
