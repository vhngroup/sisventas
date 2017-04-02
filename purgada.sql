-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2017 a las 01:58:34
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `purgada`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` bigint(11) NOT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(256) COLLATE utf8_spanish2_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `descripccion` longtext CHARACTER SET utf8,
  `imagen` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `impuesto` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `idbanco` int(11) NOT NULL,
  `nombre_banco` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` bigint(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripccion` varchar(256) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `idcotizacion` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `idcliente` int(11) NOT NULL,
  `notas` longtext COLLATE utf8_spanish2_ci,
  `descripccion` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(20,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idproyecto` int(11) DEFAULT NULL,
  `num_comprobante` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `condiciones` longtext COLLATE utf8_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `idcuenta` int(11) NOT NULL,
  `idbanco` int(11) NOT NULL,
  `idtipocuenta` int(11) NOT NULL,
  `numerodecuenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecotizacion`
--

CREATE TABLE `detallecotizacion` (
  `iddetallecotizacion` int(11) NOT NULL,
  `idcotizacion` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalledepedido`
--

CREATE TABLE `detalledepedido` (
  `iddetalledepedido` int(11) NOT NULL,
  `idpedido` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalledeventa`
--

CREATE TABLE `detalledeventa` (
  `iddetalledeventa` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Disparadores `detalledeventa`
--
DELIMITER $$
CREATE TRIGGER `tr_RestoreStockDeleteVenta` AFTER DELETE ON `detalledeventa` FOR EACH ROW BEGIN
UPDATE articulo set stock = stock + OLD.cantidad
where articulo.idarticulo;
End
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockventa` AFTER INSERT ON `detalledeventa` FOR EACH ROW BEGIN
UPDATE articulo set stock = stock - NEW.cantidad
where articulo.idarticulo = new.idarticulo;
End
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
UPDATE articulo set stock = stock + new.cantidad
where articulo.idarticulo= NEW.idarticulo;
End
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto`
--

CREATE TABLE `impuesto` (
  `idimpuesto` int(11) NOT NULL,
  `porcentaje` decimal(4,2) NOT NULL,
  `descripccion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `impuesto`
--

INSERT INTO `impuesto` (`idimpuesto`, `porcentaje`, `descripccion`, `Estado`) VALUES
(1, '0.00', 'Excento', 'A'),
(2, '16.00', 'Iva', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `numero_comprobante` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `anticipo` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `total_venta` decimal(20,2) NOT NULL,
  `idproyecto` int(11) DEFAULT NULL,
  `condiciones` longtext,
  `num_comprobante` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombrecontacto` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `num_documento` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Notas` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tipocuenta` varchar(45) CHARACTER SET utf8 NOT NULL,
  `banco` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `numerodecuenta` decimal(14,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `idproyecto` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `Descripccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `alerta1` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechaalerta1` datetime DEFAULT NULL,
  `alerta2` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechaalerta2` datetime DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocuenta`
--

CREATE TABLE `tipocuenta` (
  `idtipocuenta` int(11) NOT NULL,
  `Tipodecuenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `idpago` int(11) NOT NULL,
  `tipodepago` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`idpago`, `tipodepago`) VALUES
(1, 'Efectivo'),
(2, 'Credito'),
(3, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `num_comprobante` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(20,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idproyecto` int(11) NOT NULL,
  `anticipo` decimal(20,2) NOT NULL,
  `Condiciones` longtext COLLATE utf8_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`idbanco`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`idcotizacion`),
  ADD KEY `fk_cotizacion_persona_idx` (`idcliente`),
  ADD KEY `fk_cotizacion_proyecto_idx` (`idproyecto`) USING BTREE;

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`idcuenta`),
  ADD KEY `Fk_cuenta_persona_idx` (`idpersona`),
  ADD KEY `fk_cuenta_banco_idx` (`idbanco`),
  ADD KEY `fk_cuenta_tipcuenta_idx` (`idtipocuenta`);

--
-- Indices de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`iddetallecotizacion`),
  ADD KEY `fk_detallecotizacion_cotizacion_idx` (`idcotizacion`),
  ADD KEY `fk_detallecotizacion_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalledepedido`
--
ALTER TABLE `detalledepedido`
  ADD PRIMARY KEY (`iddetalledepedido`),
  ADD KEY `fk_dentalle_pedido_articulo_idx` (`idarticulo`),
  ADD KEY `fk_detalle_pedido_pedido_idx` (`idpedido`);

--
-- Indices de la tabla `detalledeventa`
--
ALTER TABLE `detalledeventa`
  ADD PRIMARY KEY (`iddetalledeventa`),
  ADD KEY `fk_dentalle_venta_articulo_idx` (`idarticulo`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD PRIMARY KEY (`idimpuesto`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idpedido`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`idproyecto`),
  ADD KEY `fk_proyecto_persona_idx` (`idpersona`);

--
-- Indices de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  ADD PRIMARY KEY (`idtipocuenta`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`idpago`) USING BTREE;

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_cliente_idx` (`idcliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `idbanco` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `idcotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  MODIFY `iddetallecotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT de la tabla `detalledeventa`
--
ALTER TABLE `detalledeventa`
  MODIFY `iddetalledeventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `idimpuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idpedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `idproyecto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  MODIFY `idtipocuenta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `fk_cotizacion_persona` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_proyecto` FOREIGN KEY (`idproyecto`) REFERENCES `proyecto` (`idproyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `Fk_cuenta_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cuenta_banco` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cuenta_tipcuenta` FOREIGN KEY (`idtipocuenta`) REFERENCES `tipocuenta` (`idtipocuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD CONSTRAINT `fk_detallecotizacion_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detallecotizacion_cotizacion` FOREIGN KEY (`idcotizacion`) REFERENCES `cotizacion` (`idcotizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalledepedido`
--
ALTER TABLE `detalledepedido`
  ADD CONSTRAINT `fk_dentalle_pedido_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_pedido_pedido` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalledeventa`
--
ALTER TABLE `detalledeventa`
  ADD CONSTRAINT `fk_dentalle_venta_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `fk_detalle_ingreso` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ingreso_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `fk_proyecto_ingreso` FOREIGN KEY (`idproyecto`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proyecto_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
