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
  `importante` tinyint(1) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Tees','Tees','SHORT SLEEVE TEES\r\n\r\n5.3 oz preshrunk 100% heavyweight cotton\r\nDouble-needle sleeve and bottom hems\r\nTaped neck and shoulders\r\n7/8\" rib collar\r\nClassic fit \r\nSewn in Label\r\nUnisex sizing\r\nNo two shirts are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','8f1771f63d6e06178e1ed1c99933a8cf.jpg',0,'2025-05-01'),(2,'Crewneck','Crewneck','CREW NECK FLEECE\r\nUpdate: Transitioning from 80% ring spun cotton, 20% polyester to 60% ringspun cotton face, 40% polyester \r\n8.5 oz.\r\n1x1 ribbed cuffs and waistband with spandex\r\nSofter feel and reduced pilling\r\nClassic fit \r\nSewn on Label\r\nUnisex sizing\r\nNo two crew neck fleece  are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','f7a1a2b5d8ccbc35c59234c1b8718cbc.jpg',0,'2025-05-01'),(3,'Crop-Hoodie','Crop Hoodie','CROP HOODIES\r\nUpdate: Transitioning from 6.5 oz. 80% ring spun cotton, 20% polyester to 60% ringspun cotton face, 40% polyester \r\nRaw edge at waist\r\nDyed-to-match drawcord\r\nDropped shoulder\r\nRibbed cuffs\r\nSide seam\r\nRelaxed fit\r\nSewn in Label\r\nNo two hoodies are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','700a1515f121b03fa5ddb8766502cb01.jpg',0,'2025-05-01'),(4,'Denim-Jackets','Denim Jackets','TIE DYE JACKET\r\n12 oz., 99% combed ringspun cotton, 1% spandex\r\nClassic denim jacket tie-dyed\r\nChest pockets with button flap closure\r\nLoose Fit\r\nUnisex sizing\r\nEnlarged print space on the back\r\n','ae82ef4ebbccbb1a918e54f5bb466e96.jpg',1,'2025-05-01'),(5,'Jogger','Jogger','JOGGERS\r\n\r\n8.25 oz. \r\n80% ring spun cotton 20% polyester. \r\nClassic fit \r\nDouble-needle stitching throughout\r\nbig pocket for extra carry\r\nSofter feel \r\nSewn on Label\r\nUnisex sizing\r\nNo two joggers are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','e25acf25537d6c11325c0e09d9f380f1.jpg',1,'2025-05-01'),(6,'Kids','Kids','100% Cotton Classic Fit Infant and Toddler Apparel with Unique Design\r\n\r\nMade from 100% high-quality cotton, these infant and toddler garments—whether the baby creeper or the toddler tee—feature a classic fit, reinforced seams for durability, and details designed for everyday comfort. Each piece is individually treated, making every item one-of-a-kind. Wash separately to preserve its unique character and color.','583751fe2dfbc9ce10979ab590315a9b.jpg',0,'2025-05-01'),(7,'Long Sleeve','Long Sleeve','LONG SLEEVE T-SHIRT\r\n5.3 oz preshrunk 100% heavyweight cotton\r\nDouble-needle bottom hem\r\nRib cuffs\r\nTaped neck and shoulders\r\n7/8\" rib collar\r\nClassic fit \r\nSewn in Label\r\nUnisex sizing\r\nNo two long sleeve T-shirts are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','0bc9a0af9b598612718b1524614e342e.jpg',0,'2025-05-01'),(8,'Pullovers','Pullovers','PULLOVER HOODIE\r\n\r\nUpdate: Transitioning from 80% ring spun cotton, 20% polyester to 60% ringspun cotton face, 40% polyester\r\n8.5oz\r\nDouble-needle stitching throughout\r\n1x1 ribbed cuffs and waistband with spandex\r\nDouble-lined hood for added warmth with matching drawstring\r\nPouch pocket for extra carry\r\nSofter feel and reduced pilling\r\nClassic fit \r\nSewn on Label\r\nUnisex sizing\r\nNo two hoodies are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately\r\n','698c939247f479e52f2f4683036d9732.jpg',0,'2025-05-01'),(9,'Tank-Tops','Tank Tops','UNISEX TANKS\r\n5.3 oz. pre-shrunk 100% cotton \r\nClassic fit \r\nDouble-needle stitching throughout\r\nSewn on Label\r\nNo two tank tops are exactly alike. Enjoy each for its own uniqueness. \r\nWash separately \r\n','71ba06af75d33ecba69f76311e24fffd.jpg',0,'2025-05-01'),(10,'Accesories','Accesories','Unique and Durable Accessories to Complement Every Look\r\n\r\nCrafted with care and attention to detail, our accessories are designed to add personality and function to any outfit. Each piece is made to stand out, with no two items exactly alike—ensuring a truly one-of-a-kind touch. Built for durability and style, they’re perfect for everyday use. Wash or clean separately to maintain their unique appearance.','2944bbb25e7904d6be71f92bec1aedaf.jpg',0,'2025-05-01');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (6,'negro','#1a1a1a');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencer`
--

LOCK TABLES `influencer` WRITE;
/*!40000 ALTER TABLE `influencer` DISABLE KEYS */;
INSERT INTO `influencer` VALUES (1,'aldanashow','','https://www.tiktok.com/@aldanashow','https://www.instagram.com/aldanashow/?hl=es','8df7e8d46a44137ef5e6503cebfb07b1.jpg','Obsessed with how every piece from Sevendye is one-of-a-kind. No duplicates, just vibes! ✨','2025-05-01'),(2,'ChristianChar','','https://www.tiktok.com/@christiancharrozo','https://www.instagram.com/christianchar','c82bbf0f0acfdf58c683479fee7c6fea.jpg','If you\'re into bold, unique styles—Sevendye is your new go-to. Every piece tells its own story.','2025-05-01'),(3,'lathereew','','https://www.tiktok.com/@lathere2','https://www.instagram.com/lathereew','d1dc435c107d4968c8ed39d6d9a308ff.jpg','Comfort meets creativity with Sevendye’s baby and toddler wear. So cute and so unique!','2025-05-01');
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
  `usuarios_id` int NOT NULL,
  `productos_id` int NOT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lista_deseos_usuarios1_idx` (`usuarios_id`),
  KEY `fk_lista_deseos_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_lista_deseos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `fk_lista_deseos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
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
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_imagen_productos1_idx` (`productos_id`),
  CONSTRAINT `fk_producto_imagen_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_imagen`
--

LOCK TABLES `producto_imagen` WRITE;
/*!40000 ALTER TABLE `producto_imagen` DISABLE KEYS */;
INSERT INTO `producto_imagen` VALUES (45,'308534b14faf3fcde81597e809742b8a.jpg','2025-05-01',50),(48,'c43006879e6fba984e1c42f457ea5930.jpg','2025-05-01',50),(49,'f69a8cb2d93cf6c3d0b52b88d2b91098.jpg','2025-05-01',51),(50,'affe4f5807460cbcb81bd27c5d051064.jpg','2025-05-01',52),(51,'ec1dc54e82f4f7a15866c446f66c53dd.jpg','2025-05-01',53),(52,'95024fab2eec27c0a0fc17ddd623bc42.jpg','2025-05-01',54),(54,'d207ec5355fc0bada97ec97a75e2f244.jpg','2025-05-01',55),(55,'a3bb89250f15070742886112fa2d3f64.jpg','2025-05-01',56),(56,'349d65ffbd10edc5e9015608f28c35be.jpg','2025-05-01',57),(57,'74f1d5f3c4f2a552efb28c52cf6e9685.jpg','2025-05-01',58);
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
  `slug` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` longtext,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT NULL,
  `recuento_ventas` int DEFAULT NULL,
  `categorias_id` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `actualizado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referencia_UNIQUE` (`referencia`),
  KEY `fk_productos_categorias_idx` (`categorias_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (50,'68139e099baac','Sugary-Bliss-jogger-t-shirt-seven-best-tiedye-colorful-usa-pants','Sugary Bliss jogger t shirt seven best tiedye colorful usa pants','8.25 oz.<br>\r\n80% ring spun cotton 20% polyester.<br>\r\nClassic fit<br>\r\nDouble-needle stitching throughout<br>\r\nBig pocket for extra carry<br>\r\nSofter feel<br>\r\nSewn on Label<br>\r\nUnisex sizing<br>\r\nNo two joggers are exactly alike. Enjoy each for its own uniqueness.<br>\r\nWash separately<br>',1000000,57.44,1,1,0,5,'2025-05-01',NULL),(51,'6813b0156992b','Arctic-Cascade-jogger-t-shirt-seven-best-tiedye-colorful-usa-pants','Arctic Cascade jogger t-shirt seven best tiedye colorful usa pants','8.25 oz.<br>\r\n80% ring spun cotton 20% polyester.<br>\r\nClassic fit<br>\r\nDouble-needle stitching throughout<br>\r\nBig pocket for extra carry<br>\r\nSofter feel<br>\r\nSewn on Label<br>\r\nUnisex sizing<br>\r\nNo two joggers are exactly alike. Enjoy each for its own uniqueness.<br>\r\nWash separately<br>\r\n',10000000,57.44,1,0,0,5,'2025-05-01',NULL),(52,'6813b0f58ca24','Azure-Oasis-jogger-t-shirt-seven-best-tiedy-colorful-usa-pants','Azure Oasis jogger t-shirt seven best tiedy colorful usa pants','8.25 oz.<br>\r\n80% ring spun cotton 20% polyester.<br>\r\nClassic fit<br>\r\nDouble-needle stitching throughout<br>\r\nBig pocket for extra carry<br>\r\nSofter feel<br>\r\nSewn on Label<br>\r\nUnisex sizing<br>\r\nNo two joggers are exactly alike. Enjoy each for its own uniqueness.<br>\r\nWash separately<br>',10000000,57.44,1,0,0,5,'2025-05-01',NULL),(53,'6813b1a48b81e','Eternal-Cosmos-jogger-t-shirt-seven-best-tiedye-colorful-usa-pants','Eternal Cosmos jogger t-shirt seven best tiedye colorful usa pants','8.25 oz.<br>\r\n80% ring spun cotton 20% polyester.<br>\r\nClassic fit<br>\r\nDouble-needle stitching throughout<br>\r\nBig pocket for extra carry<br>\r\nSofter feel<br>\r\nSewn on Label<br>\r\nUnisex sizing<br>\r\nNo two joggers are exactly alike. Enjoy each for its own uniqueness.<br>\r\nWash separately<br>',1000000,57.44,1,1,0,5,'2025-05-01',NULL),(54,'6813b3806cd81','Azure-Oasis-denim-jacket-t-shirt-seven-best-tiedye-colorful-usa-denim','Azure Oasis denim jacket t-shirt seven best tiedye colorful usa denim','12 oz., 99% combed ringspun cotton, 1% spandex<br>\r\nClassic denim jacket tie-dyed<br>\r\nChest pockets with button flap closure<br>\r\nLoose Fit<br>\r\nUnisex sizing<br>\r\nEnlarged print space on the back<br>\r\n\r\n',10000000,102.40,1,1,0,4,'2025-05-01',NULL),(55,'6813b4a092a06','eternal-cosmos-denim-jacket-t-shirt-seven-best-tie-dye-colorful-usa-denim','Eternal Cosmos Denim Jacket T-Shirt Seven Best Tie-Dye Colorful USA Denim','12 oz., 99% combed ringspun cotton, 1% spandex<br>\r\nClassic denim jacket tie-dyed<br>\r\nChest pockets with button flap closure<br>\r\nLoose Fit<br>\r\nUnisex sizing<br>\r\nEnlarged print space on the back<br>\r\n',1000000000,102.40,1,0,0,4,'2025-05-01',NULL),(56,'6813b55df1c84','midnight-mirage-denim-jacket-t-shirt-seven-best-tie-dye-colorful-usa-denim','Midnight Mirage Denim Jacket T-Shirt Seven Best Tie-Dye Colorful USA Denim','12 oz., 99% combed ringspun cotton, 1% spandex<br>\r\nClassic denim jacket tie-dyed<br>\r\nChest pockets with button flap closure<br>\r\nLoose Fit<br>\r\nUnisex sizing<br>\r\nEnlarged print space on the back<br>\r\n',1000000,102.40,1,1,0,4,'2025-05-01',NULL),(57,'6813b5d1cd42d','navy-nebula-denim-jacket-t-shirt-seven-best-tie-dye-colorful-usa-denim','Navy Nebula Denim Jacket T-Shirt Seven Best Tie-Dye Colorful USA Denim','12 oz., 99% combed ringspun cotton, 1% spandex<br>\r\nClassic denim jacket tie-dyed<br>\r\nChest pockets with button flap closure<br>\r\nLoose Fit<br>\r\nUnisex sizing<br>\r\nEnlarged print space on the back<br>\r\n',0,102.40,1,0,0,4,'2025-05-01',NULL),(58,'6813b68187c93','sugary-bliss-denim-jacket-t-shirt-seven-best-tie-dye-colorful-usa-denim','Sugary Bliss Denim Jacket T-Shirt Seven Best Tie-Dye Colorful USA Denim','12 oz., 99% combed ringspun cotton, 1% spandex<br>\r\nClassic denim jacket tie-dyed<br>\r\nChest pockets with button flap closure<br>\r\nLoose Fit<br>\r\nUnisex sizing<br>\r\nEnlarged print space on the back<br>',1000000,102.40,1,1,0,4,'2025-05-01',NULL);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_colores`
--

DROP TABLE IF EXISTS `productos_colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_colores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colores_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productos_id` (`productos_id`),
  KEY `colores_id` (`colores_id`),
  CONSTRAINT `productos_colores_ibfk_1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `productos_colores_ibfk_2` FOREIGN KEY (`colores_id`) REFERENCES `colores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_colores`
--

LOCK TABLES `productos_colores` WRITE;
/*!40000 ALTER TABLE `productos_colores` DISABLE KEYS */;
INSERT INTO `productos_colores` VALUES (59,6,51),(61,6,52),(66,6,55),(68,6,57),(70,6,50),(71,6,56),(72,6,58),(73,6,54),(74,6,53);
/*!40000 ALTER TABLE `productos_colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_tallas`
--

DROP TABLE IF EXISTS `productos_tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_tallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `precio` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `tallas_id` int NOT NULL,
  `productos_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tallas_id` (`tallas_id`),
  KEY `productos_id` (`productos_id`),
  CONSTRAINT `productos_tallas_ibfk_2` FOREIGN KEY (`tallas_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `productos_tallas_ibfk_3` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=631 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_tallas`
--

LOCK TABLES `productos_tallas` WRITE;
/*!40000 ALTER TABLE `productos_tallas` DISABLE KEYS */;
INSERT INTO `productos_tallas` VALUES (551,57.44,1,5,51),(552,57.44,1,6,51),(553,57.44,1,7,51),(554,57.44,1,8,51),(555,62.24,1,9,51),(561,57.44,1,5,52),(562,57.44,1,6,52),(563,57.44,1,7,52),(564,57.44,1,8,52),(565,62.24,1,9,52),(586,102.40,1,5,55),(587,102.40,1,6,55),(588,102.40,1,7,55),(589,102.40,1,8,55),(590,112.00,1,9,55),(596,102.40,1,5,57),(597,102.40,1,6,57),(598,102.40,1,7,57),(599,102.40,1,8,57),(600,112.00,1,9,57),(606,57.44,1,5,50),(607,57.44,1,6,50),(608,57.44,1,7,50),(609,57.44,1,8,50),(610,62.24,1,9,50),(611,102.40,1,5,56),(612,102.40,1,6,56),(613,102.40,1,7,56),(614,102.40,1,8,56),(615,112.00,1,9,56),(616,102.40,1,5,58),(617,102.40,1,6,58),(618,102.40,1,7,58),(619,102.40,1,8,58),(620,112.00,1,9,58),(621,102.40,1,5,54),(622,102.40,1,6,54),(623,102.40,1,7,54),(624,102.40,1,8,54),(625,112.00,1,9,54),(626,57.44,1,5,53),(627,57.44,1,6,53),(628,57.44,1,7,53),(629,57.44,1,8,53),(630,62.24,1,9,53);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tallas`
--

LOCK TABLES `tallas` WRITE;
/*!40000 ALTER TABLE `tallas` DISABLE KEYS */;
INSERT INTO `tallas` VALUES (13,'2T'),(9,'2XL'),(14,'3T'),(10,'3XL'),(15,'4T'),(11,'4XL'),(12,'5XL'),(3,'KIDS 10-12'),(4,'KIDS 14-16'),(1,'KIDS 2-4'),(2,'KIDS 6-8'),(7,'LG'),(6,'MD'),(5,'SM'),(8,'XL');
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonios`
--

LOCK TABLES `testimonios` WRITE;
/*!40000 ALTER TABLE `testimonios` DISABLE KEYS */;
INSERT INTO `testimonios` VALUES (11,'5c3e98d2d2218ac50daa1c4f367115ed.jpg','Gabriel','Customer','I’m totally digging my new hoodie from Seven Dye. The fabric is crazy soft and comfy, and the tie-dye design gives it some serious cool vibes. It’s hands down become my go-to for chillin’ in style!','2025-05-01',NULL),(12,'f27b614eeca373f1c1b20d17e73555b6.jpg','Julieth','Customer','In love and registered with your brand. They are very versatile garments. Indispensable to give color and life to any type of outfit. Highly recommended.','2025-05-01',NULL),(13,'8a2eef44b0f6ef4286fc4c7210fc66df.jpg','Jessica','Customer','This purchase was the best decision, I love the mix of colors and the comfort, I live in a hot city, and this T-shirt has been my best friend! Seven dye you rock! ','2025-05-01',NULL),(14,'45037a642bbf9407a543ce4800df1283.jpg','Daniela','Customer','I love Sevendye! Their colors and quality are unbeatable. I got matching tees with friends—everyone loved them! Perfect for the gym, beach, or just brightening up my outfit.','2025-05-01',NULL),(17,'9b502eb6b6efd3d4d44019ab82d8a022.jpg','Brittany','Customer','Wore a Sevendye shirt for a hippie Halloween look—huge success! The colors were perfect, and I was comfy all night.','2025-05-01',NULL),(18,'8d54dd0be4c8a0ba2b79fc42a82ad132.jpg','Indira','Customer','Bought shirts for a road trip surprise—my husband loved them! Great quality, super fast delivery. Couldn’t be happier.','2025-05-01',NULL),(19,'fc312a2541da22560ab66aa5065b2425.jpg','Caroline','Customer','I’m obsessed with Sevendye’s pinks! My Sugary Bliss shirt was exactly what I wanted. Now I need one in every shade!','2025-05-01',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'68136521be1d4','Nicolas esteban Pinzon Huaza','niespihu12@gmail.com','$2y$10$Xp7aiBh.jehLA9uGP5KGjupbLcMKuHUh0g24Rja/TBkY5Q/tUaEo6','','',2,'fa2a87a6dfd3a400ca84a983a7e32c3d.jpg','2025-05-01','2025-05-01',1,''),(18,'68140abdb56ee','','correo@correo.com','$2y$10$H70otzxkxwFDFsvvMwcCe..6OHt8YfJwgRzxuaCTXRfMcNiecMgam','','',2,'','2025-05-01','2025-05-01',1,'');
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

-- Dump completed on 2025-05-01 21:42:46
