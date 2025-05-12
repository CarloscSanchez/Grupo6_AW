-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: vm007.db.swarm.test
-- Tiempo de generación: 12-05-2025 a las 09:03:54
-- Versión del servidor: 10.4.28-MariaDB-1:10.4.28+maria~ubu2004
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bookswap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idevento` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `genero` varchar(100) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idevento`, `nombre`, `fecha`, `hora`, `lugar`, `genero`) VALUES
(1, 'Encuentro de Lectores', '2025-06-01', '17:00:00', 'Biblioteca Central UCAM', 'Literario'),
(2, 'Noche de Poesía', '2025-06-04', '17:15:00', 'Centro Cívico', 'Infantil'),
(3, 'Feria del Libro Infantil', '2025-06-07', '17:30:00', 'Centro Cívico', 'Fantasía'),
(4, 'Maratón de Lectura', '2025-06-10', '17:45:00', 'Auditorio Municipal', 'Poesía'),
(5, 'Club de Misterio', '2025-06-13', '18:00:00', 'Centro Cívico', 'Cómic'),
(6, 'Tarde de Cómics', '2025-06-16', '18:15:00', 'Auditorio Municipal', 'Terror'),
(7, 'Jornada Fantástica', '2025-06-19', '18:30:00', 'Auditorio Municipal', 'Romántico'),
(8, 'Relatos de Terror', '2025-06-22', '18:45:00', 'Centro Cívico', 'Histórico'),
(9, 'Café Literario', '2025-06-25', '19:00:00', 'Auditorio Municipal', 'Ciencia ficción'),
(10, 'Romance bajo las Estrellas', '2025-06-28', '19:15:00', 'Salón de Lectura', 'Misterio'),
(12, 'Pizza Literaria', '2025-05-31', '20:00:00', 'Telepizza Moncloa', 'Aventuras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intercambios`
--

CREATE TABLE `intercambios` (
  `idintercambio` int(11) NOT NULL,
  `id_libro_ofrecido` int(11) DEFAULT NULL,
  `id_libro_solicitado` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `estado` enum('pendiente','aceptado','rechazado','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_intercambio` date DEFAULT NULL
);

--
-- Volcado de datos para la tabla `intercambios`
--

INSERT INTO `intercambios` (`idintercambio`, `id_libro_ofrecido`, `id_libro_solicitado`, `id_solicitante`, `id_propietario`, `estado`, `fecha_intercambio`) VALUES
(1, NULL, 28, 5, 1, 'rechazado', NULL),
(2, 50, 15, 5, 6, 'completado', '2025-05-11'),
(3, 63, 38, 6, 5, 'aceptado', '2025-05-11'),
(4, 32, 39, 5, 6, 'aceptado', '2025-05-11'),
(5, NULL, 52, 8, 1, 'cancelado', NULL),
(6, NULL, 58, 8, 1, 'pendiente', NULL),
(7, NULL, 38, 2, 5, 'rechazado', NULL),
(8, NULL, 21, 2, 6, 'pendiente', NULL),
(9, NULL, 53, 2, 8, 'pendiente', NULL),
(10, 71, 16, 8, 1, 'cancelado', '2025-05-11'),
(11, NULL, 22, 7, 1, 'pendiente', NULL),
(12, 24, 31, 7, 2, 'completado', '2025-05-11'),
(13, NULL, 17, 1, 8, 'pendiente', NULL),
(14, 27, 7, 6, 2, 'completado', '2025-05-11'),
(15, NULL, 19, 6, 2, 'pendiente', NULL),
(16, NULL, 16, 7, 1, 'pendiente', NULL),
(17, 69, 66, 6, 7, 'aceptado', '2025-05-11'),
(18, NULL, 10, 6, 7, 'pendiente', NULL),
(19, NULL, 66, 6, 7, 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `idlibro` int(11) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `autor` varchar(256) NOT NULL,
  `genero` varchar(256) NOT NULL,
  `editorial` varchar(256) NOT NULL,
  `idioma` varchar(256) NOT NULL,
  `estado` enum('nuevo','bueno','aceptable','deteriorado') NOT NULL DEFAULT 'bueno',
  `descripcion` text NOT NULL,
  `imagen` varchar(256) NOT NULL,
  `idpropietario` int(11) NOT NULL,
  `disponible` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_publicacion` date NOT NULL DEFAULT current_timestamp()
);

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`idlibro`, `titulo`, `autor`, `genero`, `editorial`, `idioma`, `estado`, `descripcion`, `imagen`, `idpropietario`, `disponible`, `fecha_publicacion`) VALUES
(2, 'ERIK VOGLER 2: Muerte en el balneario', 'Beatriz Osés', 'Misterio y suspenso', 'Edebé', 'Español', 'bueno', 'Erik Vogler viaja a un balneario para relajarse, pero las vacaciones se complican cuando empiezan a ocurrir misteriosas muertes y él debe resolver el caso antes de que sea demasiado tarde.', 'img/erik-vogler-2.jpg', 1, 1, '2025-03-07'),
(3, 'Soldados de Salamina', 'Javier Cercas', 'Histórica', 'Tusquets Editores', 'Español', 'nuevo', 'Hacia el final de la guerra se produjo, cerca de la frontera con Francia, un fusilamiento de prisioneros franquistas. Uno de ellos escapó con vida, gracias a un joven soldado republicano, y se pudo refugiar en el bosque. Se trataba de Rafael Sánchez Mazas, poeta, fundador de Falange y futuro ministro de Franco.', 'img/soldados-de-salamina.png', 2, 1, '2025-03-07'),
(4, 'La sombra del viento', 'Carlos Ruíz Zafón', 'Filosofía', 'Planeta', 'Español', 'bueno', 'La trama se desenvuelve en una embrujada Barcelona donde, junto a su nuevo amigo Fermín, intentará descubrir la verdad que envuelve a un enigmático ser que a toda costa intenta enterrar el pasado de Julián Carax. ​ Una novela de suspenso que intenta mezclar lo real con la fantasía, el misterio con el amor.', 'img/la-sombra-del-viento.jpeg', 2, 1, '2025-03-07'),
(5, 'La isla de la mujer dormida', 'Arturo Pérez-Reverte', 'Histórica', 'Alfaguara', 'Español', 'bueno', 'En plena Guerra Civil Española, un marino se embarca en una peligrosa misión en el mar Egeo, donde el amor y la traición acechan entre las olas.', 'img/la-isla-de-la-mujer-dormida.jpg', 1, 1, '2025-03-07'),
(6, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 'Editorial Sudamericana', 'Español', 'bueno', 'La historia de la familia Buendía en el pueblo ficticio de Macondo, explorando temas de soledad y realismo mágico.', 'img/cienañosdesoledad.jpg', 1, 1, '2025-03-07'),
(7, 'Pedro Páramo', 'Juan Rulfo', 'Realismo mágico', 'Fondo de Cultura Económica', 'Español', 'aceptable', 'Un joven viaja al pueblo de Comala en busca de su padre, descubriendo un lugar habitado por fantasmas y recuerdos.', 'img/pedroparamo.jpeg', 6, 0, '2025-03-07'),
(8, '1984', 'George Orwell', 'Distopía', 'Secker &amp; Warburg', 'Español', 'nuevo', 'Una visión sombría de un futuro totalitario donde el Gran Hermano vigila a todos los ciudadanos.', 'img/1984.jpeg', 5, 1, '2025-03-07'),
(9, 'Un mundo feliz', 'Aldous Huxley', 'Distopía', 'Chatto &amp; Windus', 'Español', 'bueno', 'Una sociedad futurista que ha alcanzado la estabilidad a través de la manipulación genética y el condicionamiento psicológico.', 'img/unmundofeliz.jpeg', 6, 1, '2025-03-07'),
(10, 'La casa de los espíritus', 'Isabel Allende', 'Novela', 'Plaza &amp; Janés', 'Español', 'bueno', 'Una saga familiar que mezcla lo político y lo místico en Chile del siglo XX.', 'img/lacasadelosespiritus.jpeg', 7, 1, '2025-03-07'),
(11, 'Crimen y castigo', 'Fiódor Dostoievski', 'Novela', 'The Russian Messenger', 'Español', 'aceptable', 'La lucha interna de un joven estudiante que comete un asesinato y enfrenta las consecuencias morales y legales.', 'img/crimenycastigo.jpeg', 8, 1, '2025-03-07'),
(12, 'Cuentos completos', 'Jorge Luis Borges', 'Cuento', 'Emecé Editores', 'Español', 'bueno', 'Una recopilación de cuentos que exploran temas como los laberintos, los espejos y la infinitud.', 'img/cuentoscompletosborges.jpg', 7, 1, '2025-03-07'),
(13, 'Cuentos completos', 'Julio Cortázar', 'Cuento', 'Alfaguara', 'Español', 'nuevo', 'Una colección de cuentos que desafían la lógica y exploran lo fantástico en lo cotidiano.', 'img/cuentoscompletos.jpg', 2, 1, '2025-03-07'),
(14, 'Dune', 'Frank Herbert', 'Ciencia ficción', 'Chilton Books', 'Español', 'bueno', 'La historia de Paul Atreides y su destino en el planeta desértico Arrakis, fuente de la especia melange.', 'img/dune.jpeg', 5, 1, '2025-03-07'),
(15, 'Neuromante', 'William Gibson', 'Ciencia ficción', 'Ace Books', 'Español', 'aceptable', 'Un hacker es contratado para realizar un ataque cibernético en un mundo dominado por la inteligencia artificial.', 'img/neuromante.jpeg', 5, 0, '2025-03-07'),
(16, 'El nombre del viento', 'Patrick Rothfuss', 'Fantasía', 'DAW Books', 'Español', 'bueno', 'Kvothe, un músico prodigio, narra la historia de su vida desde su infancia hasta convertirse en una leyenda.', 'img/elnombredelviento.jpg', 1, 1, '2025-03-07'),
(17, 'Canción de hielo y fuego: Juego de tronos', 'George R.R. Martin', 'Fantasía', 'Bantam Books', 'Español', 'nuevo', 'Una épica lucha por el trono de hierro en un mundo lleno de traiciones, guerras y criaturas míticas.', 'img/canciondehieloyfuego.jpeg', 8, 1, '2025-03-07'),
(18, 'It', 'Stephen King', 'Terror', 'Viking Press', 'Español', 'bueno', 'Un grupo de niños enfrenta a una entidad maligna que adopta la forma de un payaso para acecharlos.', 'img/it.jpeg', 7, 1, '2025-03-07'),
(19, 'El exorcista', 'William Peter Blatty', 'Terror', 'Harper &amp; Row', 'Español', 'aceptable', 'Una joven es poseída por una entidad demoníaca y dos sacerdotes intentan liberarla.', 'img/elexorcista.jpeg', 2, 1, '2025-03-07'),
(20, 'La chica del tren', 'Paula Hawkins', 'Misterio y suspenso', 'Riverhead Books', 'Español', 'bueno', 'Una mujer se ve envuelta en la desaparición de otra tras observar algo extraño desde el tren.', 'img/lachicadeltren.jpeg', 5, 1, '2025-03-07'),
(21, 'Los hombres que no amaban a las mujeres', 'Stieg Larsson', 'Misterio y suspenso', 'Norstedts Förlag', 'Español', 'nuevo', 'Un periodista y una hacker investigan la desaparición de una joven ocurrida décadas atrás.', 'img/loshombresquenoamaban.jpeg', 6, 1, '2025-03-07'),
(22, 'Orgullo y prejuicio', 'Jane Austen', 'Romance', 'T. Egerton', 'Español', 'bueno', 'La historia de amor entre Elizabeth Bennet y el orgulloso señor Darcy en la Inglaterra georgiana.', 'img/orgulloyprejuicio.jpeg', 1, 1, '2025-03-07'),
(23, 'Yo antes de ti', 'Jojo Moyes', 'Romance', 'Michael Joseph', 'Español', 'bueno', 'Una joven se convierte en cuidadora de un hombre paralizado y ambos cambian la vida del otro.', 'img/yoantesdeti.jpeg', 8, 1, '2025-03-07'),
(24, 'Las aventuras de Tom Sawyer', 'Mark Twain', 'Aventura', 'American Publishing Company', 'Español', 'aceptable', 'Las travesías de un niño travieso y soñador en el sur de Estados Unidos en el siglo XIX.', 'img/lasaventurasdetomsawyer.jpeg', 2, 0, '2025-03-07'),
(25, 'Veinte mil leguas de viaje submarino', 'Jules Verne', 'Aventura', 'Pierre-Jules Hetzel', 'Español', 'bueno', 'Un viaje extraordinario a bordo del submarino Nautilus junto al misterioso capitán Nemo.', 'img/veintemilleguas.jpeg', 2, 1, '2025-03-07'),
(26, 'Los pilares de la Tierra', 'Ken Follett', 'Histórica', 'Macmillan', 'Español', 'nuevo', 'Una novela épica sobre la construcción de una catedral en la Inglaterra medieval y las vidas de quienes la rodean.', 'img/lospilaresdelatierra.jpeg', 5, 1, '2025-03-07'),
(27, 'Yo, Claudio', 'Robert Graves', 'Histórica', 'Cassell', 'Español', 'bueno', 'Autobiografía ficticia del emperador romano Claudio que revela intrigas, traiciones y secretos del imperio.', 'img/yoclaudio.jpeg', 2, 0, '2025-03-07'),
(28, 'Hamlet', 'William Shakespeare', 'Drama', 'Penguin Classics', 'Español', 'bueno', 'Una tragedia sobre el príncipe danés que busca vengar la muerte de su padre.', 'img/hamlet.jpeg', 1, 1, '2025-03-07'),
(29, 'Casa de muñecas', 'Henrik Ibsen', 'Drama', 'Gyldendal', 'Español', 'aceptable', 'Una mujer lucha por su independencia y dignidad en una sociedad patriarcal.', 'img/casademunycas.jpeg', 8, 1, '2025-03-07'),
(30, 'Más allá del bien y del mal', 'Friedrich Nietzsche', 'Filosofía', 'C.G. Naumann', 'Español', 'bueno', 'Una crítica a la moral tradicional y una exploración del pensamiento filosófico moderno.', 'img/masalladelbienydelmal.jpeg', 7, 1, '2025-03-07'),
(31, 'Meditaciones', 'Marco Aurelio', 'Filosofía', 'Penguin Classics', 'Español', 'nuevo', 'Reflexiones del emperador romano sobre la vida, el deber y la virtud en un tono estoico.', 'img/meditaciones.jpeg', 7, 0, '2025-03-07'),
(32, 'El arte de amar', 'Erich Fromm', 'Psicología', 'Harper &amp; Row', 'Español', 'bueno', 'Un análisis psicológico y filosófico del amor como un arte que debe aprenderse y practicarse.', 'img/elartedeamar.jpeg', 5, 1, '2025-03-07'),
(33, 'Los hombres son de Marte, las mujeres de Venus', 'John Gray', 'Psicología', 'HarperCollins', 'Español', 'aceptable', 'Una guía para mejorar la comunicación y comprensión entre hombres y mujeres.', 'img/hombresmartemujeresvenus.jpeg', 6, 1, '2025-03-07'),
(34, 'Breves respuestas a las grandes preguntas', 'Stephen Hawking', 'Ciencia y divulgación científica', 'Bantam Books', 'Español', 'nuevo', 'Reflexiones finales de Hawking sobre el universo, la inteligencia artificial, y el futuro de la humanidad.', 'img/brevesrespuestasalasgrandespreguntas.jpeg', 1, 1, '2025-03-07'),
(35, 'Cosmos', 'Carl Sagan', 'Ciencia y divulgación científica', 'Random House', 'Español', 'bueno', 'Una exploración científica y filosófica del universo, la vida y nuestra existencia.', 'img/cosmos.jpeg', 8, 1, '2025-03-07'),
(36, 'Los 7 hábitos de la gente altamente efectiva', 'Stephen R. Covey', 'Autoayuda y desarrollo personal', 'Free Press', 'Español', 'bueno', 'Un enfoque práctico para lograr objetivos personales y profesionales mediante hábitos efectivos.', 'img/los7habitosdelagenteefectiva.png', 7, 1, '2025-03-07'),
(37, 'El poder del ahora', 'Eckhart Tolle', 'Autoayuda y desarrollo personal', 'New World Library', 'Español', 'nuevo', 'Una guía espiritual para vivir el presente y alcanzar la iluminación personal.', 'img/elpoderdelahora.jpeg', 2, 1, '2025-03-07'),
(38, 'La política', 'Aristóteles', 'Política', 'Gredos', 'Español', 'aceptable', 'Un tratado filosófico sobre la organización del Estado y el papel del ciudadano.', 'img/lapolitica.jpg', 5, 1, '2025-03-07'),
(39, 'El príncipe', 'Nicolás Maquiavelo', 'Política', 'Antonio Blado d’Asola', 'Español', 'bueno', 'Una obra fundamental del pensamiento político sobre cómo obtener y mantener el poder.', 'img/elprincipe.jpeg', 6, 1, '2025-03-07'),
(40, 'El capital', 'Karl Marx', 'Economía', 'Dietz Verlag', 'Español', 'deteriorado', 'Un análisis crítico de la economía capitalista y sus consecuencias sociales.', 'img/elcapital.jpeg', 1, 1, '2025-03-07'),
(41, 'Freakonomics', 'Steven D. Levitt y Stephen J. Dubner', 'Economía', 'William Morrow', 'Español', 'bueno', 'Una exploración de los incentivos ocultos detrás del comportamiento humano usando la economía.', 'img/freakonomics.jpeg', 8, 1, '2025-03-07'),
(42, 'En las antípodas', 'Bill Bryson', 'Viajes y exploración', 'Anchor Books', 'Español', 'aceptable', 'Una mirada humorística y detallada a Australia a través de los ojos del autor.', 'img/enlasantipodas.jpeg', 7, 1, '2025-03-07'),
(43, 'Hacia rutas salvajes', 'Jon Krakauer', 'Viajes y exploración', 'Villard', 'Español', 'bueno', 'La historia real de Christopher McCandless, quien abandonó todo para vivir en la naturaleza.', 'img/haciarutassalvajes.jpeg', 2, 1, '2025-03-07'),
(44, 'El libro del desasosiego', 'Fernando Pessoa', 'Religión y espiritualidad', 'Assírio &amp; Alvim', 'Español', 'aceptable', 'Reflexiones espirituales y filosóficas del heterónimo Bernardo Soares.', 'img/librodeldesasosiego.jpeg', 5, 1, '2025-03-07'),
(45, 'El profeta', 'Khalil Gibran', 'Religión y espiritualidad', 'Alfred A. Knopf', 'Español', 'bueno', 'Una colección de ensayos poéticos sobre temas espirituales y humanos.', 'img/elprofeta.jpeg', 6, 1, '2025-03-07'),
(46, 'Veinte poemas de amor y una canción desesperada', 'Pablo Neruda', 'Poesía lírica', 'Editorial Nascimento', 'Español', 'bueno', 'Una de las obras más célebres de la poesía amorosa del siglo XX.', 'img/veintepoemasdeamor.jpeg', 1, 1, '2025-03-07'),
(47, 'Antología poética', 'Federico García Lorca', 'Poesía lírica', 'Espasa-Calpe', 'Español', 'aceptable', 'Selección de poemas que reflejan el universo lírico y trágico del poeta andaluz.', 'img/antologiapoeticalorca.jpeg', 8, 1, '2025-03-07'),
(48, 'Esperando a Godot', 'Samuel Beckett', 'Dramaturgia', 'Faber and Faber', 'Español', 'bueno', 'Dos hombres esperan a alguien llamado Godot en una obra clave del teatro del absurdo.', 'img/esperandoagodot.jpeg', 7, 1, '2025-03-07'),
(49, 'El zoo de cristal', 'Tennessee Williams', 'Dramaturgia', 'Random House', 'Español', 'nuevo', 'Drama familiar centrado en una madre dominante, su hija introvertida y un hijo que desea escapar.', 'img/elzoodecristal.jpeg', 2, 1, '2025-03-07'),
(50, 'Edipo rey', 'Sófocles', 'Teatro clásico y contemporáneo', 'Gredos', 'Español', 'bueno', 'Una tragedia clásica sobre el destino, la verdad y la autodestrucción.', 'img/ediporey.jpeg', 6, 0, '2025-03-07'),
(51, 'Bodas de sangre', 'Federico García Lorca', 'Teatro clásico y contemporáneo', 'Espasa-Calpe', 'Español', 'aceptable', 'Tragedia rural inspirada en hechos reales, con una gran carga simbólica y poética.', 'img/bodasdesangre.jpeg', 6, 1, '2025-03-07'),
(52, 'Naruto Vol. 1', 'Masashi Kishimoto', 'Manga', 'Shueisha', 'Español', 'bueno', 'Las aventuras de Naruto Uzumaki, un joven ninja con un espíritu indomable.', 'img/narutovol1.jpeg', 1, 1, '2025-03-07'),
(53, 'Death Note Vol. 1', 'Tsugumi Ohba y Takeshi Obata', 'Manga', 'Shueisha', 'Español', 'nuevo', 'Un estudiante encuentra un cuaderno con el poder de matar a cualquier persona cuyo nombre escriba en él.', 'img/deathnotevol1.jpeg', 8, 1, '2025-03-07'),
(54, 'Batman: Año Uno', 'Frank Miller y David Mazzucchelli', 'Superhéroes', 'DC Comics', 'Español', 'bueno', 'Una mirada al primer año de Bruce Wayne como el Caballero Oscuro.', 'img/batmanañouno.jpeg', 7, 1, '2025-03-07'),
(55, 'Spider-Man: Blue', 'Jeph Loeb y Tim Sale', 'Superhéroes', 'Marvel Comics', 'Español', 'aceptable', 'Peter Parker recuerda su relación con Gwen Stacy en una historia melancólica y emotiva.', 'img/spidermanazul.jpeg', 2, 1, '2025-03-07'),
(56, 'Tintín en el Tíbet', 'Hergé', 'Historieta europea', 'Casterman', 'Español', 'bueno', 'El joven reportero Tintín emprende un viaje al Himalaya para rescatar a su amigo Chang.', 'img/tintineneltibet.jpeg', 5, 1, '2025-03-07'),
(57, 'Astérix el Galo', 'René Goscinny y Albert Uderzo', 'Historieta europea', 'Dargaud', 'Español', 'nuevo', 'Las aventuras de los irreductibles galos frente al Imperio Romano.', 'img/asterixelgalo.jpeg', 6, 1, '2025-03-07'),
(58, 'Maus', 'Art Spiegelman', 'Novela gráfica independiente', 'Pantheon Books', 'Español', 'bueno', 'Relato autobiográfico sobre el Holocausto, narrado a través de ratones y gatos.', 'img/maus.jpeg', 1, 1, '2025-03-07'),
(59, 'Persépolis', 'Marjane Satrapi', 'Novela gráfica independiente', 'L’Association', 'Español', 'bueno', 'Memorias de la autora sobre su infancia en Irán durante y después de la revolución islámica.', 'img/persepolis.png', 8, 1, '2025-03-07'),
(60, 'Donde viven los monstruos', 'Maurice Sendak', 'Cuentos infantiles', 'Harper &amp; Row', 'Español', 'bueno', 'Max viaja a una tierra de monstruos donde se convierte en su rey y aprende sobre la importancia del hogar.', 'img/dondevivenlosmonstruos.jpeg', 7, 1, '2025-03-07'),
(61, 'El Grúfalo', 'Julia Donaldson', 'Cuentos infantiles', 'Macmillan Children’s Books', 'Español', 'nuevo', 'Un ratón inteligente engaña a sus depredadores inventando una criatura temible llamada Grúfalo.', 'img/elgrufalo.jpeg', 2, 1, '2025-03-07'),
(62, 'Bajo la misma estrella', 'John Green', 'Literatura juvenil (Young Adult - YA)', 'Dutton Books', 'Español', 'bueno', 'Hazel y Gus son dos adolescentes con cáncer que descubren el amor y el sentido de la vida juntos.', 'img/bajolamismaestrella.jpeg', 5, 1, '2025-03-07'),
(63, 'Los juegos del hambre', 'Suzanne Collins', 'Literatura juvenil (Young Adult - YA)', 'Scholastic', 'Español', 'nuevo', 'Katniss Everdeen debe luchar por su vida en un torneo mortal televisado por el Capitolio.', 'img/losjuegosdelhambre.jpeg', 6, 1, '2025-03-07'),
(64, 'Las fábulas de Esopo', 'Esopo', 'Fábulas y cuentos clásicos', 'Alianza Editorial', 'Español', 'aceptable', 'Colección de relatos breves protagonizados por animales con enseñanzas morales.', 'img/lasfabulasdeesopo.jpeg', 1, 1, '2025-03-07'),
(65, 'Cuentos de los hermanos Grimm', 'Jacob y Wilhelm Grimm', 'Fábulas y cuentos clásicos', 'Penguin Classics', 'Español', 'bueno', 'Compilación de cuentos clásicos como Caperucita Roja, Blancanieves y Hansel y Gretel.', 'img/cuentosdelosgrimm.jpeg', 8, 1, '2025-03-07'),
(66, 'El árbol rojo', 'Shaun Tan', 'Libros ilustrados', 'Lothian Books', 'Español', 'nuevo', 'Un libro ilustrado que retrata emociones complejas con imágenes poéticas y simbólicas.', 'img/elarbolrojo.jpeg', 7, 1, '2025-03-07'),
(67, 'La cosa perdida', 'Shaun Tan', 'Libros ilustrados', 'Lothian Books', 'Español', 'bueno', 'Un niño encuentra una extraña criatura y se embarca en una aventura para ayudarla a encontrar su lugar.', 'img/lacosaperdida.jpeg', 2, 1, '2025-03-07'),
(68, 'El diario de Ana Frank', 'Ana Frank', 'Biografía y autobiografía', 'Contact Publishing', 'Español', 'bueno', 'Relato íntimo y conmovedor de una adolescente escondida durante la ocupación nazi en Ámsterdam.', 'img/eldiariodeanafrank.jpeg', 5, 1, '2025-03-07'),
(69, 'Long Walk to Freedom', 'Nelson Mandela', 'Biografía y autobiografía', 'Little, Brown', 'Español', 'nuevo', 'Autobiografía de Mandela, desde su infancia hasta su presidencia y lucha contra el apartheid.', 'img/longwalktofreedom.jpeg', 6, 1, '2025-03-07'),
(70, 'La rebelión de las masas', 'José Ortega y Gasset', 'Ensayo', 'Espasa Calpe', 'Español', 'aceptable', 'Ensayo filosófico y sociológico sobre el surgimiento de la masa como figura dominante en la sociedad moderna.', 'img/larebeliondelasmasas.jpeg', 1, 1, '2025-03-07'),
(71, 'Apología de Sócrates', 'Platón', 'Ensayo', 'Gredos', 'Español', 'bueno', 'Relato del juicio a Sócrates, donde defiende su vida de pensamiento y búsqueda de la verdad.', 'img/apologiadesocrates.jpeg', 8, 1, '2025-03-07'),
(72, 'Sapiens: De animales a dioses', 'Yuval Noah Harari', 'Historia', 'Harvill Secker', 'Español', 'nuevo', 'Una historia global del desarrollo del Homo sapiens desde la prehistoria hasta la era moderna.', 'img/sapiensdeanimalesadioses.jpeg', 7, 1, '2025-03-07'),
(73, 'Guns, Germs, and Steel', 'Jared Diamond', 'Historia', 'W. W. Norton &amp; Company', 'Español', 'bueno', 'Explica cómo la geografía y los recursos naturales moldearon el destino de las civilizaciones humanas.', 'img/gunsgermsandsteel.jpeg', 2, 1, '2025-03-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `correo` varchar(256) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `imagen` varchar(256) DEFAULT NULL,
  `tipo` enum('admin','normal') NOT NULL DEFAULT 'normal'
) ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `correo`, `contraseña`, `imagen`, `tipo`) VALUES
(1, 'Usuario1', 'carlocle@ucm.es', '$2y$10$rg/LXwGMYo2Bxvp.9s9/o.MOCjqT483tVzQTsGSBC4H00X0Kk.fDG', 'img/foto con espacios perfil.jpg', 'normal'),
(2, 'Usuario2', 'ismaluca@ucm.es', '$2y$10$4LetN37hfEKv0ZE50/2DIukCE09sf.v.g9nmVQmhuxmHMkoldeh..', 'img/foto_perfil_usuario2.jpg', 'normal'),
(3, 'Admin1', 'alvamo14@ucm.es', '$2y$10$sG2si0rMtkXHFHWR5NSXh.hsdklqSNwNsuJWwXExKxMdkKxgzGN8q', NULL, 'admin'),
(5, 'Usuario3', 'pablof25@ucm.es', '$2y$10$JtaMg4tugrts/wzUVXMWSewMOOmVAz4byuFdqoFVrdlmJsdo2O4Tu', 'img/foto_perfil_usuario3.png', 'normal'),
(6, 'Usuario4', 'usuario4@ucm.es', '$2y$10$Z1sMbDvI9y0ZJwGguMJqBuaYLA9509TxT6whAVaCsvG8La7MGkTsK', 'img/foto_perfil_usuario4.jpg', 'normal'),
(7, 'Usuario5', 'usuario5@ucm.es', '$2y$10$kxhLZJJaUUYvlwkivRvtDuA7IYrxk39SvFSB4bU6qlLX12J4uinga', 'img/foto_perfil_usuario5.jpg', 'normal'),
(8, 'Usuario6', 'usuario6@ucm.es', '$2y$10$Ww.3D5EhW6S9l1ZrNbJk2.hslNzF079U0OpreaxsW2zKjcaI/1vp.', 'img/foto_perfil_usuario6.jpg', 'normal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idevento`);

--
-- Indices de la tabla `intercambios`
--
ALTER TABLE `intercambios`
  ADD PRIMARY KEY (`idintercambio`),
  ADD KEY `intercambios_ibfk_1` (`id_libro_ofrecido`),
  ADD KEY `intercambios_ibfk_2` (`id_libro_solicitado`),
  ADD KEY `intercambios_ibfk_3` (`id_solicitante`),
  ADD KEY `intercambios_ibfk_4` (`id_propietario`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`idlibro`),
  ADD KEY `libros_ibfk_1` (`idpropietario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `intercambios`
--
ALTER TABLE `intercambios`
  MODIFY `idintercambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `idlibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `intercambios`
--
ALTER TABLE `intercambios`
  ADD CONSTRAINT `intercambios_ibfk_1` FOREIGN KEY (`id_libro_ofrecido`) REFERENCES `libros` (`idlibro`),
  ADD CONSTRAINT `intercambios_ibfk_2` FOREIGN KEY (`id_libro_solicitado`) REFERENCES `libros` (`idlibro`),
  ADD CONSTRAINT `intercambios_ibfk_3` FOREIGN KEY (`id_solicitante`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `intercambios_ibfk_4` FOREIGN KEY (`id_propietario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`idpropietario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
