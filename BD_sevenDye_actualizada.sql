-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: sevendye_crud
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulos_pedidos`
--

DROP TABLE IF EXISTS `articulos_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int DEFAULT NULL,
  `costo_por_unidad` decimal(10,2) DEFAULT NULL,
  `ordenes_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_articulos_pedidos_ordenes1_idx` (`ordenes_id`),
  KEY `fk_articulos_pedidos_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_articulos_pedidos_ordenes1` FOREIGN KEY (`ordenes_id`) REFERENCES `ordenes` (`id`),
  CONSTRAINT `fk_articulos_pedidos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos_pedidos`
--

LOCK TABLES `articulos_pedidos` WRITE;
/*!40000 ALTER TABLE `articulos_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulos_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `usuarios_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrito_usuarios1_idx` (`usuarios_id`),
  KEY `fk_carrito_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_carrito_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `fk_carrito_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` longtext,
  `imagen` varchar(200) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (2,'/carta','Que mas pues','Hola Hola hHola hHola hHola hHola hHola hHola hHola hHola hHola hHola h','c67f3cd1e082704b12754dd1ead28c15.jpg','2025-04-18','2025-04-18');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `hexadecimal` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (2,'rojo','#cd2323'),(3,'verde','#00ff4c'),(4,'negro','#000000');
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupones`
--

DROP TABLE IF EXISTS `cupones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cupones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `descripcion` longtext,
  `tipo_descuento` varchar(45) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `tipo_pedido_minimo` varchar(45) DEFAULT NULL,
  `minimo_pedido` decimal(10,2) DEFAULT NULL,
  `expira` timestamp NULL DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupones`
--

LOCK TABLES `cupones` WRITE;
/*!40000 ALTER TABLE `cupones` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `influencer`
--

DROP TABLE IF EXISTS `influencer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `influencer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencer`
--

LOCK TABLES `influencer` WRITE;
/*!40000 ALTER TABLE `influencer` DISABLE KEYS */;
/*!40000 ALTER TABLE `influencer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_deseos`
--

DROP TABLE IF EXISTS `lista_deseos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lista_deseos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `usuarios_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lista_deseos_usuarios1_idx` (`usuarios_id`),
  KEY `fk_lista_deseos_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_lista_deseos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `fk_lista_deseos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_deseos`
--

LOCK TABLES `lista_deseos` WRITE;
/*!40000 ALTER TABLE `lista_deseos` DISABLE KEYS */;
/*!40000 ALTER TABLE `lista_deseos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `referencia` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `usuarios_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referencia_UNIQUE` (`referencia`),
  KEY `fk_ordenes_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_ordenes_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_imagen`
--

DROP TABLE IF EXISTS `producto_imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_imagen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(200) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_imagen_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_producto_imagen_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_imagen`
--

LOCK TABLES `producto_imagen` WRITE;
/*!40000 ALTER TABLE `producto_imagen` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `referencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` longtext,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio_descuento` decimal(10,2) DEFAULT NULL,
  `colores_id` int DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT NULL,
  `recuento_ventas` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `categorias_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referencia_UNIQUE` (`referencia`),
  KEY `fk_productos_categorias_idx` (`categorias_id`),
  KEY `colores_id` (`colores_id`),
  CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`colores_id`) REFERENCES `colores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_tallas`
--

DROP TABLE IF EXISTS `productos_tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_tallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int DEFAULT NULL,
  `tallas_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productos_id` (`productos_id`),
  KEY `tallas_id` (`tallas_id`),
  CONSTRAINT `productos_tallas_ibfk_1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `productos_tallas_ibfk_2` FOREIGN KEY (`tallas_id`) REFERENCES `tallas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_tallas`
--

LOCK TABLES `productos_tallas` WRITE;
/*!40000 ALTER TABLE `productos_tallas` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_tallas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reseñas_productos`
--

DROP TABLE IF EXISTS `reseñas_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reseñas_productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `observaciones` longtext,
  `calificacion` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `usuarios_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reseñas_productos_usuarios1_idx` (`usuarios_id`),
  KEY `fk_reseñas_productos_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_reseñas_productos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `fk_reseñas_productos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reseñas_productos`
--

LOCK TABLES `reseñas_productos` WRITE;
/*!40000 ALTER TABLE `reseñas_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `reseñas_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'cliente'),(2,'administrador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tallas`
--

DROP TABLE IF EXISTS `tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tallas`
--

LOCK TABLES `tallas` WRITE;
/*!40000 ALTER TABLE `tallas` DISABLE KEYS */;
INSERT INTO `tallas` VALUES (6,'2XL '),(7,'AC '),(4,'LG '),(3,'MD '),(2,'SM '),(5,'XL '),(1,'XSM');
/*!40000 ALTER TABLE `tallas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonios`
--

DROP TABLE IF EXISTS `testimonios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(200) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `mensaje` longtext,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonios`
--

LOCK TABLES `testimonios` WRITE;
/*!40000 ALTER TABLE `testimonios` DISABLE KEYS */;
INSERT INTO `testimonios` VALUES (8,'1abc4fdab182e56e7629e7f0881b31eb.jpg','Julieth','Customer','In love and registered with your brand. They are very versatile garments. Indispensable to give color and life to any type of outfit. Highly recommended.','2025-04-02',NULL),(9,'3bba8332da4099fa41b578f36930b03a.jpg','Jessicaaa','Customer','This purchase was the best decision, I love the mix of colors and the comfort, I live in a hot city, and this T-shirt has been my best friend! Seven dye you rock! ','2025-04-02',NULL);
/*!40000 ALTER TABLE `testimonios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `referencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contraseña` char(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text,
  `rolId` int DEFAULT NULL,
  `imagen` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referencia_UNIQUE` (`referencia`),
  KEY `rolId` (`rolId`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rolId`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'','Nicolás Esteban Pinzón Huaza','niespihu12@gmail.com','$2y$10$Dx0KXfQ6TYvn8A1ed66ZNef5DA1Zwssy/xTECZONcfTpQBBrOOmXy','3134869103','Transversal 9#17a-25',2,'6e59020d388f0b7f5b88b563b0d742e4.jpg','2025-04-14','2025-04-14',1,''),(4,'67fd7934b2cc6','','correo@correo.com','$2y$10$bZZrHbvArS7ne8YgWKb5yeyVoNCNEVR8zBb2X9vh1s2UtlKu2ODdi','','',1,'','2025-04-14','2025-04-14',1,''),(5,'67fe8454a85f2','','juan@mail.com','$2y$10$h/MYxlw1NGiOZwUVIMNRTu0qIeo0cgCP1qAK6MduvOZTWanxKkCMu','','',1,'','2025-04-15','2025-04-15',1,''),(6,'67fe8603870ee','','dickson@hotmail.com','$2y$10$iiLVbfs3KnbugC37ynrFruLigiqifNqJu7PJxnalVXgEEj5W8dPgy','','',1,'','2025-04-15','2025-04-15',1,''),(7,'67fe86a1efd02','','mami@mail.com','$2y$10$SDmFZc4TP6VzxjT34ZLDrubCKGekDFDsSiSIM3BOtyl9XeFSZ7Zji','','',1,'','2025-04-15','2025-04-15',1,''),(8,'67feadc4ab787','','juan@gmail.com','$2y$10$rEHdSTzZo/p09ljMxCY4bONgLoa9RZ3/YBo1.nmBIzdtT1S98Cj0m','','',1,'','2025-04-15','2025-04-15',1,''),(9,'67ffb469ad4e6','','vicky@gmail.com','$2y$10$iQjR4j9yy71XuCJtcqD6TuZaExClhhC8tjGT8O0KSubj1FGmJrG9e','','',1,'','2025-04-16','2025-04-16',1,'');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-21 21:59:34
