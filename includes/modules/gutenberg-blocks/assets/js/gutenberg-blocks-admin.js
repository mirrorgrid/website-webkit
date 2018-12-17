/* eslint-disable */

(function ($) {
    'use strict';

    var blocks = [{
        label: 'Button (Improved)',
        name: 'gutenberg-blocks/button-block',
        active: true,
    },
    {
        label: 'Call To Action',
        name: 'gutenberg-blocks/call-to-action',
        active: true,
    },
    {
        label: 'Click To Tweet',
        name: 'gutenberg-blocks/click-to-tweet',
        active: true,
    },
    {
        label: 'Content Toggle',
        name: 'gutenberg-blocks/content-toggle',
        active: true,
    },
    {
        label: 'Divider',
        name: 'gutenberg-blocks/divider',
        active: true,
    },
    {
        label: 'Feature Box',
        name: 'gutenberg-blocks/feature-box',
        active: true,
    },
    {
        label: 'Notification Box',
        name: 'gutenberg-blocks/notification-box',
        active: true,
    },
    {
        label: 'Number Box',
        name: 'gutenberg-blocks/number-box',
        active: true,
    },
    {
        label: 'Star Rating',
        name: 'gutenberg-blocks/star-rating',
        active: true
    },
    {
        label: 'Social Share',
        name: 'gutenberg-blocks/social-share',
        active: true
    },
    {
        label: 'Tabbed Content',
        name: 'gutenberg-blocks/tabbed-content',
        active: true
    },
    {
        label: 'Table of Contents',
        name: 'gutenberg-blocks/table-of-contents',
        active: true
    },
    {
        label: 'Testimonial',
        name: 'gutenberg-blocks/testimonial-block',
        active: true
    },
    {
        label: 'Progress Bar',
        name: 'gutenberg-blocks/progress-bar',
        active: true
    }
    ];


    $(function () {
        var isBlocksListEmpty = $('.gutenberg_blocks_collection__item').length === 0

        if (isBlocksListEmpty) {
            insertBlocks();
        }

        $(document).on('change', 'input[name="block_status"]', function () {

            toggleBlockStatus(
                $(this),
                $(this).prop('checked'),
                $(this).closest('.gutenberg_blocks_collection__item').data('id')
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


        function insertBlocks() {
            var blocksHtml = '';

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
        }

        function toggleBlockStatus(selector, enable, id) {
            var data = {
                enable: enable,
                block_name: id,
                action: 'toggle_block_status',
                _ajax_nonce: $('input[name="gutenberg_blocks_nonce"]').val()
            };

            $.ajax({
                url: $('input[name="gutenberg_blocks_ajax_url"]').val(),
                type: 'POST',
                data: data,
                'Content-Type': 'application/json',
                success: function (data, status, xhr) {
                    selector.closest('.gutenberg_blocks_collection__item').toggleClass('active');
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

    });

})(jQuery);