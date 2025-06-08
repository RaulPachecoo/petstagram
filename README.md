# Petstagram

![Descripción de la imagen](https://files.catbox.moe/aly5gt.png)

Raúl Pacheco Ropero 						2º DAW

*Petstagram* es una aplicación web que funciona como una red social dedicada exclusivamente a animales y mascotas. Inspirada en la estructura de Instagram, permite a los usuarios crear publicaciones, seguir a otros perfiles, interactuar mediante mensajes privados, dar "me gusta" y realizar comentarios. Una de las características diferenciadoras del proyecto es la integración de un sistema de inteligencia artificial que analiza automáticamente las publicaciones para verificar que incluyan contenido relacionado con animales o mascotas y que no contengan material sensible o inapropiado. Además, la plataforma incluye un blog de acceso público, disponible incluso para usuarios no registrados, donde se comparten artículos, consejos e información relevante sobre el mundo animal. El objetivo principal es cubrir una brecha identificada en el mercado digital, ofreciendo una plataforma especializada para los amantes de los animales que desean compartir, informarse y conectar en un entorno seguro y temáticamente enfocado.

[https://www.petstagram.es/](https://www.petstagram.es/) 

*Petstagram* is a web application that functions as a social network exclusively dedicated to animals and pets. Inspired by the structure of Instagram, it allows users to create posts, follow other profiles, interact through private messaging, like, and comment on content. A key differentiator of the project is the integration of an artificial intelligence system that automatically analyzes posts to ensure they include pet-related content and do not contain sensitive or inappropriate material. Additionally, the platform features a publicly accessible blog—available even to non-registered users—where articles, tips, and relevant information about the animal world are shared. The main objective is to address a gap identified in the digital market by offering a specialized platform for animal lovers who want to share, learn, and connect in a safe, pet-focused environment.

[https://www.petstagram.es/](https://www.petstagram.es/) 

![Descripción de la imagen](https://files.catbox.moe/j86nja.png)

*Página principal de Petstagram*

# Índice

[**3\.	Justificación del proyecto	4**](#justificacion-del-proyecto)

[A.	Características generales	4](#caracteristicas-generales)

[B.	Restricciones generales	6](#restricciones-generales)

[C.	Aspectos cubiertos y no cubiertos	6](#aspectos-cubiertos-y-no-cubiertos)

[D.	Comparativa con herramientas similares existentes	8](#comparativa-con-herramientas-similares-existentes)

[**4\.	Justificación de la Tecnología Empleada	9**](#justificacion-de-la-tecnologia-empleada)

[**5\.	Requerimientos Hardware y Software	10**](#requerimientos-hardware-y-software)

[**6\.	Análisis y Diseño	12**](#analisis-y-diseno)

[A.	Diagrama de Casos de Uso	12](#diagrama-de-casos-de-uso)

[B.	Diagrama de Clases	13](#diagrama-de-clases)

[C.	Diseño de la Base de Datos	14](#diseno-de-la-base-de-datos)

[**7\.	Implementación del Proyecto	15**](#implementacion-del-proyecto)

[**8\.	Evaluación y Pruebas	17**](#evaluacion-y-pruebas)

[**9\.	Manual de Estilos	18**](#manual-de-estilos)

[A. 	Bocetos o sketches	18](#a.-bocetos-o-sketches)

[B. 	Criterios de accesibilidad	21](#b.-criterios-de-accesibilidad)

[C. 	Criterios de usabilidad	23](#c.-criterios-de-usabilidad)

[D.	Tipografía utilizada	24](#tipografia-utilizada)

[E.	Mapa de colores del proyecto	25](#mapa-de-colores-del-proyecto)

[F.	Dispositivos y vistas soportadas	26](#dispositivos-y-vistas-soportadas)

[**10\.	Software utilizado	26**](#software-utilizado)

[**11\.**	**Alojamiento Web	27**](#heading=h.4wicxn8breh6)

[**12\.**	**Mejoras Posibles y Aportaciones Personales	28**](#heading=h.q7kzljm6m1af)

[**13\.**	**Bibliografía	29**](#heading=h.t36j8o502e26)

# 3. Justificación del proyecto {#justificacion-del-proyecto}

##  A. **Características generales** {#caracteristicas-generales}

Petstagram es una aplicación web que funciona como una red social enfocada exclusivamente en mascotas y animales. Su objetivo principal es ofrecer un entorno donde los usuarios puedan compartir contenido relacionado con sus mascotas, interactuar con otros amantes de los animales y acceder a información útil. A continuación, se describen las principales características de la plataforma:

* **Registro y autenticación de usuarios:**  
  Los usuarios pueden crear una cuenta mediante un formulario de registro y acceder con sus credenciales de forma segura, además de disponer de la opción de registro y autenticación a través de Google.

* **Creación y visualización de publicaciones:**

Cada usuario puede crear publicaciones con una imagen y una descripción. Estas publicaciones son visibles para otros usuarios, y pueden recibir "me gusta" y comentarios.

* **Moderación automática mediante IA:**

Todas las publicaciones son analizadas automáticamente por un sistema de inteligencia artificial que detecta si el contenido incluye al menos un animal y si es apropiado, evitando contenido sensible o no relacionado, manteniendo así en todo momento la temática de la aplicación.

* **Sistema de seguidores:**

Los usuarios tienen la posibilidad de seguir a otros perfiles para ver sus publicaciones directamente en su feed personalizado. Este sistema permite crear una red de contactos basada en intereses comunes. También se ofrece la opción de dejar de seguir a un usuario en cualquier momento, en caso de que su contenido deje de resultar relevante o interesante.

* **Mensajería privada:**

Se permite la comunicación directa entre usuarios, los cuales se siguen entre sí, mediante un sistema de chat privado integrado, con posibilidad de hacer consultas a los administradores de la aplicación.

* **Blog público:**

Incluye un blog con artículos, recomendaciones y noticias sobre el mundo animal. Este blog es accesible incluso para visitantes no registrados. Las entradas del blog de momento son creadas por los administradores de la aplicación.

* **Diseño adaptable:**

La interfaz está diseñada para adaptarse a diferentes dispositivos (ordenadores, tabletas y móviles), ofreciendo una buena experiencia de usuario en todas las vistas.

* **Interfaz intuitiva y visual:**

El diseño de la plataforma sigue un enfoque moderno y claro, similar al de redes sociales populares, facilitando su uso para todo tipo de usuarios.

Estas características hacen de Petstagram una red social especializada, que no solo cubre una necesidad concreta en el mundo digital, sino que también promueve un uso responsable y seguro de la tecnología.

##  B. **Restricciones generales** {#restricciones-generales}

Aunque Petstagram busca ofrecer una experiencia completa y fluida, existen algunas restricciones a tener en cuenta tanto desde el punto de vista técnico como funcional:

* **Contenido obligatorio relacionado con animales:**

Todas las publicaciones deben incluir al menos una imagen en la que se identifique claramente un animal o mascota. Esta validación se realiza mediante un sistema de inteligencia artificial, por lo que puede haber casos puntuales de error o falsos positivos/negativos.

* **Acceso limitado a funcionalidades sin registro:**

Los usuarios no registrados solo pueden acceder a la sección del blog. Las funciones principales de la red social (como crear publicaciones, comentar o seguir a otros) requieren una cuenta activa.

* **Dependencia de conexión a Internet:**

Al tratarse de una aplicación web, es necesario contar con una conexión a Internet estable para acceder a sus funciones.

Estas restricciones han sido consideradas durante el desarrollo para garantizar un equilibrio entre funcionalidad, seguridad y rendimiento del sistema.

##  C. **Aspectos cubiertos y no cubiertos** {#aspectos-cubiertos-y-no-cubiertos}

Durante el desarrollo de Petstagram se ha definido un conjunto de funcionalidades clave que forman parte del alcance principal del proyecto, así como otros aspectos que, por cuestiones de tiempo, complejidad técnica o enfoque del proyecto, no serán implementados.

**Aspectos que se van a cubrir:**

* Registro y autenticación de usuarios:

Los usuarios podrán crear una cuenta, iniciar sesión y gestionar su perfil básico.

* Publicación de contenido (imágenes):

Se podrán crear publicaciones con imágenes y texto, visibles en un feed general y personalizado.

* Sistema de seguidores:

Los usuarios podrán seguir y dejar de seguir a otros perfiles para personalizar su experiencia dentro de la plataforma.

* Interacciones sociales:

Se permite dar "me gusta", comentar publicaciones y chatear de forma privada con otros usuarios.

* Moderación automática y manual:

Las publicaciones serán analizadas por un sistema de inteligencia artificial que verifica la presencia de animales y la ausencia de contenido inapropiado. Además, los administradores tienen acceso a todas las publicaciones para revisarlas manualmente y eliminarlas si es necesario.

* Blog público:

Se incluye una sección de blog visible para cualquier visitante, con artículos relacionados con el mundo animal.

* Diseño responsive:

La interfaz está diseñada para adaptarse a dispositivos móviles, tablets y ordenadores.

**Aspectos que no se van a cubrir:**

* Subida de vídeos:

La plataforma solo admite imágenes en las publicaciones. No se permite la subida de contenido en formato de vídeo.

* Aplicación móvil nativa:

No se desarrollará una app específica para Android o iOS, aunque la versión web es completamente funcional en dispositivos móviles.

* Notificaciones en tiempo real:

La aplicación no cuenta con un sistema de notificaciones push ni avisos instantáneos sobre interacciones o mensajes.

## D. **Comparativa con herramientas similares existentes** {#comparativa-con-herramientas-similares-existentes}

Petstagram se inspira en el funcionamiento de redes sociales ampliamente conocidas como Instagram o Facebook, pero se diferencia de ellas por estar completamente centrada en el mundo animal. A continuación, se expone una comparativa con algunas de estas herramientas:

**Instagram**

* Similitudes:

Interfaz basada en la publicación de imágenes, sistema de seguidores, "me gusta", comentarios y mensajes privados.

* Diferencias:

Instagram no está limitado a una temática específica. Petstagram, en cambio, filtra las publicaciones usando IA y garantiza que todo el contenido esté relacionado con mascotas.

**Facebook**

* Similitudes:

Permite compartir contenido, seguir perfiles, chatear y comentar.

* Diferencias:

Facebook es una red social generalista con múltiples propósitos y públicos. Petstagram se enfoca en una comunidad específica: personas que comparten el amor por los animales.

**Redes sociales de nicho (como Dogster o Petzbe)**

* Similitudes:

Están dirigidas a amantes de los animales y permiten compartir fotos de mascotas.

* Diferencias:

Algunas de estas redes están limitadas a un tipo específico de mascota o tienen funciones más limitadas. Petstagram permite una experiencia social más completa, similar a la de redes grandes, incluyendo un sistema de IA, mensajería privada y blog público.

**Ventajas de Petstagram**

* Comunidad temática clara y segmentada (amantes de los animales).  
* Moderación automática \+ manual para garantizar la calidad y seguridad del contenido.  
* Acceso a contenido útil sin necesidad de registro (blog).  
* Interfaz moderna e intuitiva, adaptada a diferentes dispositivos.

# 4. Justificación de la Tecnología Empleada {#justificacion-de-la-tecnologia-empleada}

Para el desarrollo de Petstagram se han elegido herramientas modernas, potentes y ampliamente utilizadas en el entorno del desarrollo web, que permiten construir aplicaciones eficientes, escalables y con una experiencia de usuario fluida. A continuación, se detallan las tecnologías utilizadas y los motivos de su elección:

**Laravel**

Laravel es un framework de PHP muy completo y robusto. Proporciona un sistema de rutas claro, un ORM (Eloquent) potente para manejar la base de datos, y facilita la organización del código mediante el patrón MVC. Su ecosistema y documentación son muy amplios, lo que ha facilitado tanto el aprendizaje como la implementación.

**Livewire**

Livewire se ha utilizado para añadir interactividad a la aplicación sin necesidad de escribir grandes cantidades de JavaScript y de manera más sencilla. Permite crear componentes dinámicos que se actualizan en tiempo real, manteniendo la lógica del lado del servidor. Ha sido especialmente útil para funcionalidades como el sistema de comentarios o likes sin recargar la página.

**Tailwind CSS**

Para los estilos, se ha optado por Tailwind, un framework de CSS utilitario que permite crear interfaces modernas y consistentes de forma rápida. Gracias a su enfoque basado en clases, ha sido posible mantener un diseño limpio, responsive y fácil de mantener. En algunos casos puntuales, se ha complementado con estilos CSS personalizados.

**Dropzone**

Dropzone.js se ha utilizado para mejorar la experiencia de subida de imágenes. Esta librería permite arrastrar y soltar archivos, muestra vistas previas y maneja la validación del lado del cliente de forma muy intuitiva. Ha sido clave para que el proceso de publicación sea fluido y visualmente agradable.

**JavaScript**

Aunque se ha tratado de minimizar el uso de JavaScript puro gracias a Livewire, se ha empleado en funciones específicas donde era más práctico, como:

* Manejo de eventos en el chat en tiempo real.  
* Control de la subida de imágenes.  
* Activación de modales e interfaces interactivas.

**Ollama \+ Minicpm-v**

Para la moderación automática de las publicaciones, se ha integrado Ollama, una plataforma local de ejecución de modelos de inteligencia artificial. En este caso, se ha utilizado el modelo Minicpm-v, que permite analizar las imágenes subidas por los usuarios para verificar que efectivamente contienen animales y no incluyen contenido sensible o inapropiado.

# 5. Requerimientos Hardware y Software {#requerimientos-hardware-y-software}

A continuación, se detallan los requisitos necesarios tanto del lado del cliente como del servidor para asegurar el correcto funcionamiento de Petstagram, incluyendo los recursos necesarios para la ejecución del sistema de inteligencia artificial utilizado en la moderación de contenido.

**Requerimientos del lado del cliente (usuario final)**

El usuario solo necesita un navegador moderno y acceso a Internet. La aplicación está optimizada para funcionar desde múltiples dispositivos.

* Hardware mínimo:  
* Procesador de doble núcleo (1.8 GHz o superior)  
* 2 GB de RAM  
* Resolución mínima: 1280x720  
* Conexión estable a Internet (ADSL, fibra o red móvil)

* Software necesario:  
* Navegador actualizado (Chrome, Firefox, Edge, Safari)  
* Soporte para JavaScript y CSS activado

**Requerimientos del lado del servidor (desarrollo y producción)**

El servidor donde se ejecuta la aplicación web y el sistema de IA debe contar con un entorno preparado para Laravel, además de recursos adicionales para correr el modelo de inteligencia artificial usado para la moderación automática.

* Hardware mínimo recomendado:  
* Procesador: 4 núcleos  
* 8 GB de RAM (mínimo 5 GB libres dedicados al modelo de IA)  
* 20 GB de almacenamiento disponible (especialmente si se almacenan imágenes)  
* Conexión a Internet estable

* Software necesario:  
* PHP 8.1 o superior  
* Composer (gestión de dependencias PHP)  
* MySQL   
* Node.js y NPM (para compilar los estilos y scripts)  
* Laravel 11.0

**Requisitos para el sistema de Inteligencia Artificial (IA)**

* Herramienta usada: Ollama  
* Modelo: Minicpm-v  
* Requisitos mínimos:  
* 5 GB de RAM disponibles para ejecutar el modelo  
* Soporte para contenedores o ejecución local del modelo IA  
* Sistema compatible con Ollama (Linux/macOS, o WSL en Windows)

**Herramientas en el entorno de desarrollo**

* Editor: Visual Studio Code  
* Control de versiones: Git  
* Entorno local: Docker  
* Navegadores para pruebas: Chrome, Firefox

# 6. Análisis y Diseño {#análisis-y-diseño}

##  A. **Diagrama de Casos de Uso** {#diagrama-de-casos-de-uso}

![Descripción de la imagen](https://files.catbox.moe/eslwl9.png)

##  B. **Diagrama de Clases** {#diagrama-de-clases}

   

![Descripción de la imagen](https://files.catbox.moe/guz4uk.png)
##  C. **Diseño de la Base de Datos** {#diseno-de-la-base-de-datos}

La base de datos utilizada en *Petstagram* es de tipo **relacional**, implementada sobre MySQL. La estructura de la base de datos permite gestionar usuarios, publicaciones, comentarios, likes, seguidores, visualizaciones de publicaciones, mensajería privada y entradas de blog. Se han definido claves primarias y foráneas que aseguran la integridad referencial y evitan inconsistencias.

### Entidades principales:

* **Users**: Representa a los usuarios de la plataforma. Contiene información personal como nombre, correo electrónico, nombre de usuario, contraseña, imagen de perfil y rol (usuario o administrador).

* **Posts**: Almacena las publicaciones que hacen los usuarios. Incluye título, descripción, imagen asociada y el identificador del autor.

* **Comentarios**: Permite a los usuarios comentar publicaciones. Cada comentario está asociado tanto al usuario que lo escribió como al post correspondiente.

* **Likes**: Relación N:M entre usuarios y publicaciones. Un usuario puede dar "me gusta" a varias publicaciones y cada publicación puede tener muchos "likes".

* **Followers**: Otra relación N:M que permite que un usuario siga a otros. Se registra quién sigue a quién.

* **Post\_Views**: Registra visualizaciones de publicaciones. También es una relación N:M entre usuarios y posts.

* **Messages**: Almacena mensajes privados entre usuarios. Se incluyen el remitente, destinatario, cuerpo del mensaje, su estado (leído o no) y fecha de envío.

* **Blog\_entries**: Entidad adicional para entradas de blog internas. Incluye título, contenido e imagen.


![Descripción de la imagen](https://files.catbox.moe/wro9wh.png)


# 7. Implementación del Proyecto {#implementacion-del-proyecto}

En el desarrollo de la aplicación **Petstagram** he empleado diversos elementos para estructurar, estilizar, interactuar con el usuario y gestionar la comunicación con la base de datos. A continuación, se describen los principales recursos y herramientas utilizados:

**1\. Hojas de estilo**

* **Tailwind CSS**: Es el framework principal de estilos utilizado en la aplicación. Su enfoque utilitario ha permitido diseñar componentes con clases directas en el HTML, reduciendo la necesidad de archivos CSS separados.  
* **CSS personalizado**: En casos puntuales se han aplicado estilos manuales, por ejemplo, para personalizar modales o animaciones específicas que no estaban contempladas en Tailwind.

**2\. Plantillas**

* **Blade (Laravel)**: Se han utilizado las plantillas Blade para construir la estructura HTML de la aplicación. Blade permite incluir condicionales, bucles, y reutilizar componentes mediante @include o @component, facilitando un desarrollo limpio y modular.

**3\. Formularios**

* Se han implementado formularios para:  
  * Registro y login de usuarios.  
  * Creación de publicaciones.  
  * Comentarios en posts.  
  * Envío de mensajes privados.  
* **Protección CSRF**: Todos los formularios usan la directiva @csrf de Laravel para proteger contra ataques Cross-Site Request Forgery.

**4\. Funciones de envío de datos**

* **Livewire**: Se ha utilizado para enviar datos de formularios sin recargar la página. Permite sincronizar automáticamente datos del backend con la vista.  
* **JavaScript (con Fetch/AJAX)**: Se ha usado para el manejo de eventos en el chat, subida de imágenes con Dropzone, y despliegue de interfaces dinámicas como modales.

**5\. Conexión con la base de datos**

* Laravel utiliza **Eloquent ORM**, que permite gestionar las relaciones con la base de datos de forma orientada a objetos. Cada modelo representa una tabla de la base de datos.  
* Se han utilizado migraciones para definir las tablas, y algunas factories para insertar datos de prueba

**6\. Consultas y selección de la base de datos**

* Las consultas se han realizado principalmente mediante **Eloquent**.  
* Ejemplos de consultas típicas:  
  * Obtener todos los posts de un usuario.  
  * Contar los likes de una publicación.  
  * Recuperar mensajes no leídos.  
  * Verificar si un usuario sigue a otro.

**7\. Uso de fichero de configuración**

1. Laravel centraliza la configuración en archivos ubicados en la carpeta config/. Los más relevantes han sido:  
   * config/database.php: para definir el tipo de conexión y credenciales de la base de datos.  
   * config/services.php: Este archivo ha sido esencial para la integración con servicios externos como Google. Se ha utilizado para configurar las credenciales necesarias para el inicio de sesión y registro mediante OAuth con Google.  
   * .env: archivo de variables de entorno. Contiene las credenciales reales (como nombre de la BD, usuario, contraseña, puerto, claves secretas, etc.). Esto permite modificar la configuración sin tocar el código fuente directamente.

   # 

# 8. Evaluación y Pruebas {#evaluacion-y-pruebas}

Para garantizar el correcto funcionamiento de **Petstagram**, se ha llevado a cabo un proceso de testeo que abarca tanto la aplicación web como la base de datos. El objetivo ha sido detectar y corregir errores, verificar que se cumplen los requisitos funcionales y asegurar una experiencia de usuario fluida y sin fallos críticos.

 **Validación y verificación de campos**

Se han implementado múltiples validaciones del lado del servidor utilizando las reglas de validación que proporciona Laravel. Estas aseguran que los datos introducidos por el usuario cumplan los formatos y requisitos esperados antes de ser procesados o almacenados.

Ejemplos de validaciones:

* Registro:  
  * El email debe tener un formato válido.  
  * La contraseña debe tener al menos 8 caracteres.  
  * El nombre de usuario debe ser único.  
* Publicaciones:  
  * El título y la descripción no pueden estar vacíos.  
* Comentarios:  
  * No se permite enviar un comentario vacío.  
* Entradas del Blog:  
  * El título y el contenido no pueden estar vacíos.  
  * La imagen debe tener un formato aceptado (JPG, PNG…)

En caso de error, el sistema devuelve mensajes claros al usuario, resaltando el campo incorrecto y explicando qué debe corregirse, lo que mejora la realimentación al usuario.

**Testeo de funcionalidad mediante pruebas manuales**

Se ha utilizado una batería de pruebas manuales que simulan las principales acciones del usuario para garantizar que todos los flujos funcionen correctamente. Algunos ejemplos son:

* Registro y login (con usuario y con Google).  
* Subida de publicaciones con imagen y texto.  
* Visualización de publicaciones y detalles.  
* Comentarios y likes funcionales en tiempo real.  
* Seguimiento y dejar de seguir usuarios.  
* Envío y recepción de mensajes en el chat.  
* Borrado de publicaciones por parte del administrador.  
* Filtrado por publicaciones propias o de seguidos.

Además, la aplicación ha sido testeada por varias personas cercanas (amigos)**,** quienes han interactuado con la plataforma y ofrecido su retroalimentación. Sus opiniones han sido de gran ayuda para detectar errores, mejorar la usabilidad y ajustar pequeñas funcionalidades.

**Testeo de la base de datos**

1. Se han probado inserciones, actualizaciones y eliminaciones para asegurarse de que las restricciones ON DELETE CASCADE funcionen como se espera.  
2. Las pruebas han incluido también la persistencia de datos: que los cambios realizados desde la aplicación se reflejen correctamente en la base de datos.

En conjunto, estas pruebas han permitido validar el correcto comportamiento de Petstagram y garantizar que tanto la lógica del servidor como la estructura de datos ofrecen robustez, coherencia y una experiencia fluida al usuario final.

# 

# 9. Manual de Estilos {#manual-de-estilos}

## **A. Bocetos o sketches** {#a.-bocetos-o-sketches}

**Login Page**

![Descripción de la imagen](https://files.catbox.moe/one45s.png)

**Register Page**

![Descripción de la imagen](https://files.catbox.moe/ae2y17.png)

**Home Page**

![Descripción de la imagen](https://files.catbox.moe/jgyo4n.png)

**Profile Page**

![Descripción de la imagen](https://files.catbox.moe/gto1ya.png)

**Chat Page**

![Descripción de la imagen](https://files.catbox.moe/zt7wt5.png)

**Blog Page**

![Descripción de la imagen](https://files.catbox.moe/dc7kxz.png)

**Create Page**

![Descripción de la imagen](https://files.catbox.moe/vdcqbc.png)

## B**. Criterios de accesibilidad** {#b.-criterios-de-accesibilidad}

Con el objetivo de garantizar que **Petstagram** sea una aplicación inclusiva, se ha realizado un análisis basado en las Pautas de Accesibilidad para el Contenido Web (WCAG) 2.1, en su nivel de conformidad AA, que es el exigido legalmente en muchas jurisdicciones.

A continuación, se evalúa el cumplimiento de cada uno de los criterios de este nivel:

| Criterio | Descripción | ¿Lo cumple Petstagram? |
| :---- | :---- | :---- |
| **1.2.4 Subtítulos (En Vivo)** | Todo audio en vivo debe tener subtítulos en tiempo real. | NO (La página web no incluye audio en vivo) |
| **1.2.5 Audiodescripción (Pregrabado)** | Los vídeos deben incluir audiodescripción si contienen información visual esencial. | NO (Petstgram no incluye vídeos) |
| **1.3.4 Orientación** | El contenido no debe estar restringido a orientación vertical u horizontal. | SÍ |
| **1.3.5 Identificación del Propósito de Entrada** | Los campos del formulario deben identificar su propósito semánticamente (autocomplete). | NO |
| **1.4.3 Contraste (Mínimo)** | El texto debe tener un contraste de al menos 4.5:1 (3:1 para texto grande). | SÍ |
| **1.4.4 Redimensionamiento del Texto** | El texto debe poder ampliarse al 200% sin pérdida de funcionalidad. | SÍ |
| **1.4.5 Imágenes de Texto** | Evitar el uso de imágenes que contengan texto. | SÍ |
| **1.4.10 Reajuste del Texto** | No debe ser necesario hacer scroll horizontal en pantallas pequeñas (320 px). | SÍ |
| **1.4.11 Contraste en Elementos No Textuales** | Elementos interactivos deben tener al menos 3:1 de contraste. | SÍ |
| **1.4.12 Espaciado del Texto** | El usuario debe poder ajustar interlineado y espaciado sin romper el diseño. | NO |
| **1.4.13 Controles de Entrada Accesibles** | Los inputs deben ser utilizables sin gestos complejos. | SÍ |
| **2.4.5 Múltiples Formas de Navegación** | El contenido debe poder encontrarse por diferentes métodos (buscador, menú, etc.). | SÍ |
| **2.4.6 Encabezados y Etiquetas Claras** | Los títulos y etiquetas deben reflejar correctamente su propósito. | SÍ |
| **2.4.7 Foco Visible** | Los elementos deben mostrar claramente el foco de teclado. | SÍ |
| **2.5.1 Modos de Entrada** | No deben requerirse gestos complejos para interactuar. | SÍ |
| **3.1.2 Idioma de las Partes** | Si el contenido incluye varios idiomas, estos deben declararse correctamente. | NO (Petstagram solo incluye contenido en español) |
| **3.2.3 Navegación Consistente** | La estructura de navegación debe ser coherente en todas las vistas. | SÍ |
| **3.2.4 Identificación Consistente** | Los elementos repetidos deben comportarse de forma predecible. | SÍ |
| **3.3.3 Sugerencias ante Errores** | Cuando el usuario comete un error, deben mostrarse sugerencias útiles. | SÍ |
| **3.3.4 Prevención de Errores Críticos** | Confirmación en acciones como eliminar publicaciones o enviar formularios sensibles. | NO |
| **4.1.3 Mensajes de Estado** | Los mensajes de estado (éxito, error) deben ser accesibles para lectores de pantalla. | SÍ |

## **C. Criterios de usabilidad** {#c.-criterios-de-usabilidad}

Con el objetivo de comprobar que **Petstagram** ofrece una experiencia sencilla, intuitiva y agradable, se ha realizado una prueba de usabilidad con cinco usuarios reales que simulan perfiles distintos. A cada uno se le pidió completar tareas comunes dentro de la aplicación. Posteriormente, se recogió su retroalimentación.

**Usuarios Simulados**

* **Lucía (20 años)** – Estudiante universitaria amante de los gatos. Usa redes sociales diariamente. Interesada en subir fotos de su mascota y ver las de otros.  
* **Miguel (30 años)** – Trabaja en tecnología. Usa herramientas digitales constantemente. Quiso probar el sistema de login con Google y el chat.  
* **Sofía (45 años)** – Madre de familia con poca experiencia en redes. Su objetivo era encontrar fácilmente publicaciones de mascotas que sigue.  
* **Pablo (25 años)** – Fotógrafo aficionado. Probó la subida de publicaciones con imagen y descripción, así como la edición posterior.  
* **Ana (60 años)** – Amante de los animales, pero poco familiarizada con webs modernas. Evaluó si la navegación era clara para personas mayores.

**Tareas Realizadas**

1. Registrarse o iniciar sesión (con correo y con Google).  
2. Subir una publicación con imagen y descripción.  
3. Comentar y dar “me gusta” en publicaciones.  
4. Usar el chat para enviar un mensaje a otro usuario.  
5. Filtrar publicaciones para ver solo las de seguidos.  
6. Acceder al blog y leer una entrada.

**Resultados**

* **Lucía**: Fluidez total. Sugirió añadir hashtags para filtrar publicaciones temáticamente.  
* **Miguel**: Valoró muy positivamente la integración con Google y la rapidez del chat.  
* **Sofía**: Encontró dificultades iniciales para entender el sistema de seguidos, pero lo comprendió tras usarlo un poco. Propuso un pequeño tutorial inicial.  
* **Pablo**: Sugirió mejoras en el editor de publicaciones, como poder añadir ubicación.  
* **Ana**: Tuvo problemas con el tamaño del texto y la ubicación del menú móvil. Agradeció el diseño limpio pero pidió más contraste.

**Mejoras Identificadas**

* Añadir un pequeño tutorial inicial para nuevos usuarios.  
* Ampliar opciones en las publicaciones (hashtags, ubicación).  
* Mejorar el contraste en algunos botones para mayor accesibilidad.  
* Aumentar el tamaño del texto en móviles.  
* Valorar la inclusión de una guía de ayuda sencilla o una sección de preguntas frecuentes.

##  **D. Tipografía utilizada** {#tipografia-utilizada}

En el diseño de Petstagram se ha optado por una combinación de tipografías modernas y legibles, que refuerzan tanto la estética amigable de la red social como la claridad en la lectura de los contenidos:

| Tipografía | Uso | Características |
| :---- | :---- | :---- |
| **Poppins** | Nombre de la web / logotipo / títulos destacados | Sans serif geométrica, moderna y visualmente atractiva. Proporciona un toque juvenil y tecnológico. Ideal para destacar elementos clave. |
| **Inter** | Texto del cuerpo, formularios, descripciones, menús y publicaciones | Sans serif optimizada para pantallas. Ofrece una lectura cómoda y limpia en distintos tamaños y dispositivos. Muy utilizada en interfaces web actuales. |

## **E. Mapa de colores del proyecto** {#mapa-de-colores-del-proyecto}

| Nombre del color | Hexadecimal | RGB | Aplicación en la web |
| :---- | :---- | :---- | :---- |
| **Beige** | \#DDD0C8 | rgb(221, 208, 200\) | Fondo general de páginas y secciones suaves. Base neutra para no saturar visualmente. |
| **Crema** | \#EFE3D6 | rgb(239, 227, 214\) | Fondos de formularios, tarjetas suaves, o áreas secundarias con buen contraste. |
| **Acento (Morado)** | \#6A0DAD | rgb(106, 13, 173\) | Botones principales, enlaces activos, elementos interactivos. Refuerza la identidad visual. |
| **Acento oscuro** | \#3F0066 | rgb(63, 0, 102\) | Hover de botones, títulos destacados, énfasis visual, sombreado de secciones. |
| **Gris oscuro** | \#323232 | rgb(50, 50, 50\) | Texto principal, íconos, botones secundarios. Contraste perfecto con fondos claros. |
| **Fondo tarjeta** | \#F5F0E6 | rgb(245, 240, 230\) | Fondo de tarjetas de publicaciones, comentarios y perfiles. Proporciona un diseño limpio y suave. |

## **F. Dispositivos y vistas soportadas** {#dispositivos-y-vistas-soportadas}

El proyecto **Petstagram** ha sido diseñado siguiendo el principio de responsive design, lo que significa que se adapta a diferentes tamaños de pantalla y dispositivos, garantizando una experiencia de usuario óptima tanto en ordenadores como en dispositivos móviles o tabletas.

**Vistas diseñadas:**

* **Versión de escritorio**: interfaz completa con todos los elementos visibles, adecuada para pantallas grandes (≥1024px).  
* **Versión tablet**: diseño intermedio, reorganización del contenido, tamaño de fuente y botones adaptados (≥768px y \<1024px).  
* **Versión móvil**: navegación simplificada con menús colapsables (hamburguesa), tarjetas adaptadas al ancho del dispositivo, y jerarquía visual clara para pantallas pequeñas (≤767px).

**Tecnología usada:**

* **Tailwind CSS**: se ha utilizado como sistema para construir una interfaz responsiva mediante sus clases utilitarias. Sus breakpoints nativos (sm, md, lg, xl) han facilitado los distintos diseños.  
* **Media Queries personalizadas**: en algunos casos concretos se han utilizado media queries escritas manualmente en CSS para resolver casos específicos de diseño no contemplados por defecto, como ajustes finos de espaciado o visibilidad de ciertos componentes.  
* **Flexbox y Grid**: se han usado extensamente (a través de clases de Tailwind) para la distribución y alineación de elementos, asegurando que la interfaz se mantenga limpia y legible en todos los dispositivos.


# 10. Software utilizado {#software-utilizado}

A continuación se detalla el software utilizado para el desarrollo y despliegue de la aplicación **Petstagram**, indicando para qué se ha usado cada herramienta:

* **Laravel**: Framework PHP utilizado para el desarrollo del backend, la gestión de rutas, controladores, validaciones y el acceso a la base de datos mediante Eloquent ORM.

* **MySQL**: Sistema de gestión de bases de datos relacional donde se almacenan los datos de usuarios, publicaciones, comentarios, etc.

* **PHP**: Lenguaje de programación del servidor, base sobre la que se construye Laravel.

* **Blade**: Motor de plantillas de Laravel usado para crear vistas reutilizables y dinámicas.

* **Tailwind CSS**: Framework de estilos CSS con enfoque utilitario. Se ha utilizado ampliamente para construir una interfaz moderna y responsive.

* **JavaScript**: Lenguaje utilizado en el frontend para dotar de interactividad a elementos como los "likes", comentarios, validaciones y otros componentes dinámicos.

* **Composer**: Gestor de dependencias para proyectos PHP. Se ha usado para instalar Laravel y paquetes adicionales del backend.

* **NPM (Node Package Manager)**: Herramienta utilizada para gestionar paquetes y dependencias del frontend, así como para compilar los archivos CSS y JS del proyecto.

* **Vite**: Herramienta de bundling moderna empleada para optimizar la carga de recursos y ofrecer recarga en caliente durante el desarrollo.

* **Docker**: Utilizado para crear un entorno de desarrollo aislado y replicable, facilitando la ejecución del proyecto en distintos equipos o servidores.

* **Git y GitHub**: Para control de versiones y alojamiento del repositorio del proyecto. Permite mantener un historial de cambios y colaborar eficientemente.

* **VS Code**: Editor de código empleado durante todo el desarrollo del proyecto, con extensiones útiles para Laravel, Tailwind y depuración.

* **Google Cloud Console**: Utilizada para configurar las credenciales OAuth necesarias para el inicio de sesión con Google.

* **Draw.io o Figma**: Utilizados para la creación de bocetos (sketches), prototipos de interfaz y el modelo entidad-relación de la base de datos.

* **Chrome DevTools**: Herramientas de desarrollo del navegador empleadas para depurar código, ajustar estilos, verificar responsividad y analizar el rendimiento de la web.

# 

11. #  Alojamiento Web

Para el alojamiento de la aplicación **Petstagram**, se ha utilizado un servicio de VPS (Servidor Privado Virtual) proporcionado por IONOS, junto con un dominio personalizado adquirido también en la misma plataforma.

### **¿Qué es un VPS?**

Un VPS es un servidor virtualizado que funciona como un servidor dedicado, con recursos exclusivos y control total sobre su configuración. Esto permite desplegar aplicaciones web con mayor flexibilidad, seguridad y rendimiento comparado con un hosting compartido.

### **Elección de IONOS**

IONOS es un proveedor reconocido de servicios de alojamiento web que ofrece VPS con buena relación calidad-precio, escalabilidad y soporte técnico eficiente. Además, permite administrar dominios y servicios asociados desde un mismo panel de control, lo que facilita la gestión del proyecto.

### Proceso resumido para alojar Petstagram

1. **Compra del VPS y dominio:**  
   Se adquirió un VPS en IONOS con las características necesarias para soportar la aplicación y un dominio personalizado para que la página sea accesible desde internet (por ejemplo, petstagram.com).

2. **Configuración inicial del VPS:**  
   Se accedió al VPS mediante SSH para configurar el servidor: instalación de software necesario (PHP, servidor web como Apache o Nginx, base de datos, etc.), actualización del sistema operativo y configuración de seguridad básica.

3. **Despliegue de la aplicación:**  
   Se subieron los archivos del proyecto Petstagram al VPS, se configuraron las variables de entorno, se migró la base de datos y se ajustaron los permisos necesarios para el correcto funcionamiento.

4. **Configuración del dominio:**  
   Se configuraron los registros DNS del dominio comprado para que apunten a la IP del VPS, permitiendo que al escribir el dominio en el navegador, se cargue la aplicación alojada en el servidor.

5. **Pruebas y puesta en producción:**  
   Se realizaron pruebas para comprobar que la aplicación funcionara correctamente en el entorno de producción, garantizando accesibilidad, rendimiento y seguridad.

# 

12. # Mejoras Posibles y Aportaciones Personales 

A lo largo del desarrollo de **Petstagram** se ha conseguido una aplicación funcional, moderna y con una buena experiencia de usuario. Sin embargo, siempre existen áreas en las que se podrían realizar mejoras. A continuación se describen algunas posibles mejoras y aportaciones futuras:

* **Sistema de notificaciones**: Incorporar notificaciones en tiempo real (likes, nuevos seguidores, mensajes), utilizando Laravel Echo y websockets o tecnologías similares.  
* **Buscador avanzado**: Añadir filtros para buscar publicaciones por hashtags, categorías o ubicación.  
* **Modo oscuro**: Añadir una opción para cambiar entre modo claro y oscuro, respetando las preferencias del sistema del usuario.  
* **Scroll infinito**: Optimizar el rendimiento de la visualización de publicaciones implementando carga progresiva de contenido.  
* **Guía para nuevos usuarios**: Incluir un pequeño tutorial o introducción interactiva para explicar las principales funciones al registrarse por primera vez.

13. # Bibliografía

* **Curso de Laravel**   [https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/?couponCode=ACCAGE0923](https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/?couponCode=ACCAGE0923)   Curso en línea utilizado como base para el aprendizaje del framework Laravel y la estructura MVC en proyectos PHP.

* **Documentación oficial de Laravel**   [https://laravel.com/docs/12.x](https://laravel.com/docs/12.x)   Fuente principal de consulta para el uso correcto del framework Laravel, validaciones, rutas, bases de datos, autenticación, etc.

* **Documentación de Livewire**   [https://laravel-livewire.com/](https://laravel-livewire.com/)   Utilizada para la implementación de componentes interactivos y funcionalidades reactivas en la interfaz del usuario sin necesidad de JavaScript complejo.

* **Documentación de Ollama (modelo MiniCPM-V)**   [https://ollama.com/library/minicpm-v](https://ollama.com/library/minicpm-v)   Recurso empleado para comprender el uso de modelos de lenguaje locales en la arquitectura del sistema, especialmente si se integran herramientas de IA.

