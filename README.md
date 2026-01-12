# Tema Pedraja para WordPress

Tema personalizado inspirado en Falcon de PrestaShop, totalmente configurable desde el Customizer de WordPress.

## 📋 Características

✅ **Totalmente configurable** desde Apariencia > Personalizar
✅ **Sistema de widgets** para footer (hasta 4 columnas)
✅ **Ocultar títulos** de páginas globalmente o individualmente
✅ **Menús ilimitados** (principal, superior, 4 en footer)
✅ **Redes sociales** configurables
✅ **Colores personalizables**
✅ **Header sticky** opcional
✅ **Responsive** y optimizado para móviles
✅ **Compatible con WooCommerce**
✅ **Compatible con Gutenberg**

## 🚀 Instalación

1. Descarga el tema
2. Ve a **Apariencia > Temas > Añadir nuevo > Subir tema**
3. Selecciona el archivo .zip del tema
4. Activa el tema

## ⚙️ Configuración

### 1. Configuración General (Apariencia > Personalizar)

#### **Identidad del sitio**
- Logo del sitio
- Título y descripción

#### **Configuración General**
- ✅ Ocultar títulos en todas las páginas
- ✅ Ocultar título solo en la página de inicio

#### **Header**
- ✅ Mostrar barra superior
- 📝 Texto de la barra superior
- ✅ Header fijo al hacer scroll

#### **Footer**
- 🔢 Número de columnas (1-4)
- 📝 Texto de copyright
- ✅ Mostrar redes sociales

#### **Redes Sociales**
Configura las URLs de:
- Facebook
- Twitter / X
- Instagram
- LinkedIn
- YouTube
- Pinterest

#### **Colores**
- 🎨 Color primario
- 🎨 Color secundario
- 🎨 Color de enlaces

### 2. Menús (Apariencia > Menús)

Puedes crear hasta 6 menús diferentes:
- **Menú Principal**: Navegación principal del header
- **Menú Superior**: Barra superior (si está activada)
- **Footer Columna 1-4**: Menús en cada columna del footer

**Cómo crear un menú:**
1. Ve a **Apariencia > Menús**
2. Haz clic en **Crear un nuevo menú**
3. Dale un nombre
4. Selecciona la ubicación (Primary, Top Menu, Footer 1-4)
5. Añade páginas, enlaces personalizados, categorías, etc.
6. Guarda el menú

### 3. Widgets (Apariencia > Widgets)

Áreas disponibles:
- **Sidebar Principal**: Barra lateral
- **Área Superior**: Sobre el header principal
- **Footer Columna 1-4**: Widgets en el footer

**Widgets recomendados para el footer:**
- Texto/HTML personalizado
- Menú de navegación
- Últimas entradas
- Categorías
- Etiquetas
- Imágenes

### 4. Ocultar Títulos de Páginas

Tienes 3 opciones:

**Opción 1: Ocultar en todas las páginas**
1. Ve a **Apariencia > Personalizar > Configuración General**
2. Marca "Ocultar títulos en todas las páginas"

**Opción 2: Ocultar solo en la home**
1. Ve a **Apariencia > Personalizar > Configuración General**
2. Marca "Ocultar título solo en la página de inicio"

**Opción 3: Ocultar en páginas específicas**
1. Edita la página
2. En la barra lateral derecha, busca el meta box **"Opciones de Título"**
3. Marca "Ocultar título en esta página/entrada"
4. Actualiza la página

## 📁 Estructura de Archivos

```
pedraja-theme/
├── assets/
│   ├── css/
│   │   └── main.css          # Estilos principales
│   └── js/
│       └── navigation.js     # JavaScript del tema
├── functions.php             # Funciones del tema
├── header.php               # Plantilla del header
├── footer.php               # Plantilla del footer
├── page.php                 # Plantilla de páginas
├── single.php               # Plantilla de entradas
├── index.php                # Plantilla principal
├── sidebar.php              # Barra lateral
├── style.css                # Hoja de estilos principal
└── README.md                # Este archivo
```

## 🎨 Personalización Avanzada

### Colores CSS Variables

El tema usa variables CSS que puedes modificar:

```css
:root {
    --pedraja-primary: #007bff;
    --pedraja-secondary: #6c757d;
    --pedraja-link: #007bff;
    --pedraja-text: #333;
    --pedraja-light-bg: #f8f9fa;
    --pedraja-border: #dee2e6;
}
```

### Child Theme (Recomendado)

Para personalizaciones que no se pierdan con actualizaciones:

1. Crea una carpeta: `pedraja-child/`
2. Crea `style.css`:

```css
/*
Theme Name: Pedraja Child
Template: pedraja-theme
Version: 1.0.0
*/

/* Tus estilos personalizados aquí */
```

3. Crea `functions.php`:

```php
<?php
function pedraja_child_enqueue_styles() {
    wp_enqueue_style('pedraja-parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('pedraja-child', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'pedraja_child_enqueue_styles');
```

## 🔧 Funciones Útiles

### Verificar si mostrar título

```php
<?php if (pedraja_show_individual_title()) : ?>
    <h1><?php the_title(); ?></h1>
<?php endif; ?>
```

### Obtener configuraciones del Customizer

```php
// Obtener color primario
$primary_color = get_theme_mod('pedraja_primary_color', '#007bff');

// Verificar si mostrar topbar
$show_topbar = get_theme_mod('pedraja_show_topbar', true);

// Obtener número de columnas del footer
$columns = get_theme_mod('pedraja_footer_columns', '4');
```

## 🌐 Compatibilidad con WooCommerce

El tema detecta automáticamente WooCommerce y muestra:
- 🛒 Icono del carrito en el header
- 🔢 Contador de productos

## 📱 Responsive

Breakpoints:
- Desktop: > 992px
- Tablet: 768px - 992px
- Móvil: < 768px

## ❓ FAQ

**¿Cómo cambio el logo?**
Ve a Apariencia > Personalizar > Identidad del sitio > Logo

**¿Puedo tener más de 4 columnas en el footer?**
Sí, edita `functions.php` y modifica el bucle de registro de sidebars del footer.

**¿Cómo añado más redes sociales?**
Edita `functions.php` en la función `pedraja_customize_register` y añade más redes al array `$social_networks`.

**¿El tema es compatible con plugins de construcción de páginas?**
Sí, es compatible con Elementor, WPBakery, Beaver Builder, etc.

## 📞 Soporte

Para reportar bugs o solicitar características, abre un issue en el repositorio de GitHub.

## 📄 Licencia

GPL v2 o posterior

---

**Desarrollado con ❤️ para Representaciones Pedraja**
