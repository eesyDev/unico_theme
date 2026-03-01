<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	// 1. Ваша открывающая обертка
	echo '<div class="breadcrumbs">';

	foreach ( $breadcrumb as $key => $crumb ) {

		// Если ссылка существует и это НЕ последний элемент
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			// 2. Добавляем ваш класс breadcrumbs__link
			echo '<a href="' . esc_url( $crumb[1] ) . '" class="breadcrumbs__link">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			// 3. Последний элемент выводится просто текстом (без <a>)
			echo esc_html( $crumb[0] );
		}

		// 4. Выводим разделитель, если это не последний элемент
		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<span>/</span>';
		}
	}

	// Ваша закрывающая обертка
	echo '</div>';

}