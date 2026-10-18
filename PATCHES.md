# Parches propios de Infometica sobre POS 2.74

Rama `main` = `vendor` (código del autor) + estos parches. Al actualizar POS: traer la versión
nueva a `vendor`, mergearla en `main` y revisar que estos parches siguen aplicando.

| Fichero | Qué hace |
|---|---|
| `Extension/Table/variantes.xml`, `Extension/XMLView/EditVariante.xml` | Columna `variantes.descripcion` y campo editable: descripción propia por variante. |
| `Extension/Model/Variante.php` | `description()`: si la variante tiene descripción propia, es la que usan facturas, albaranes y tickets. `save()`: la primera vez que un producto llega a más de una variante pone `productos.ocultar_base = 1` (el usuario puede desmarcarla; no se reactiva). |
| `Extension/Table/productos.xml`, `Extension/XMLView/EditProducto.xml` | Columna `productos.ocultar_base` (NULL = nunca decidido) y casilla «Ocultar producto base» en la ficha del producto. |
| `Init.php` | Registra la extensión `Model\Variante`. |
| `Model/Join/ProductoVariante.php` | Descripción = variante o producto; en el TPV oculta la variante base (la que tiene la referencia del producto) si `ocultar_base = 1` y el producto tiene más de una variante. **Fichero con saltos de línea CRLF: conservarlos.** |
| `Lib/Services/Products.php` | La búsqueda del TPV también mira `variantes.descripcion`. |
| `View/Block/POS/Products/Content.html.twig` | Tarjeta de producto: familia arriba y referencia en la última línea (cuadrícula y lista). |

## Parche al Core (no es de este plugin)

`patches/core-ocultar-producto-base.patch` oculta la variante base también en los selectores de
producto de ventas y compras (`Core/Lib/AjaxForms/SalesModalHTML.php` y `PurchasesModalHTML.php`).
Se pierde al actualizar FacturaScripts: hay que reaplicarlo (`git apply`). Vive de forma efectiva
en `infometica/facturascript`.
