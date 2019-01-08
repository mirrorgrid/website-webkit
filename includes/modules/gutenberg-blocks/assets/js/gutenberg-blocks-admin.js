/* eslint-disable */
(function ($) {
    'use strict';
    $(function () {
        var isBlocksListEmpty = $('.gutenberg_blocks_collection__item').length === 0

        if (isBlocksListEmpty) {
           /* insertBlocks();*/
        }

        $(document).on('change', 'input[name="gutenberg_block_status"]', function () {


            toggleBlockStatus(
                $(this),
                $(this).prop('checked'),
                $(this).closest('tr').find('.block_name').data('id'),
            )

        });

        $(document).on('click', '.filter-action', function () {
            $('.filter-action').removeClass('active');
            $(this).addClass('active');

            var filter_status = $(this).data('filter-status');

            if (filter_status === 'all') {
                $('.gutenberg_blocks_collection__item').removeClass('gutenberg-blocks-hide');
            } else if (filter_status == 'enabled') {
                $('.gutenberg_blocks_collection__item').addClass('gutenberg-blocks-hide');
                $('.gutenberg_blocks_collection__item.active').removeClass('gutenberg-blocks-hide');
            } else if (filter_status == 'disabled') {
                $('.gutenberg_blocks_collection__item').removeClass('gutenberg-blocks-hide');
                $('.gutenberg_blocks_collection__item.active').addClass('gutenberg-blocks-hide');
            }

        });

        function toggleBlockStatus(selector, enable, id) {
            var data = {
                enable: enable,
                block_name: id,
                action: 'mww_toggle_block_status',
                _ajax_nonce: $('input[name="gutenberg_blocks_nonce"]').val()
            };
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                'Content-Type': 'application/json',
                beforeSend:function () {
                    selector.parent().find('.gutenberg-loader').toggleClass('hidden')
                },
                success: function (data, status, xhr) {
                    selector.closest('.gutenberg_blocks_collection__item').toggleClass('active');
                    selector.parent().find('.gutenberg-loader').toggleClass('hidden')
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


 /*        function insertBlocks() {
         var blocksHtml = '';
             var blocks =[];
         $.each(blocks, function (index, block) {
         //item start
         blocksHtml += '<div class="gutenberg_blocks_collection__item" data-id="' + block.name + '">';

         //item header start
         blocksHtml += '<div class="gutenberg_blocks_collection__item__header" data-id="' + block.name + '">';

         // title
         blocksHtml += '<h3 class="gutenberg_blocks_collection__item__title">' + block.label + '</h3>';
         // switch
         blocksHtml += '<label class="switch">';
         blocksHtml += '<input type="checkbox" name="block_status">';
         blocksHtml += '<span class="slider"></span>';
         blocksHtml += '</label>';

         // item header end
         blocksHtml += '</div>';

         //item end
         blocksHtml += '</div>';
         });

         $('.gutenberg_blocks_collection').html(blocksHtml);
         }*/


    });

})(jQuery);