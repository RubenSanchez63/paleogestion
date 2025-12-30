## **PaleoGestión: Aplicación CRUD para Gestión de Fósiles de un Museo de Paleontología**

Por Rubén Sánchez Quintero.

La url de acceso a la App es http://54.144.102.32/ .

Está alojada en el lab de AWS de despliegue, si no está disponible contáctame para encenderlo, pues chapa a las 4h.

## **1\. Introducción**

Este documento describe una propuesta de aplicación web de tipo CRUD diseñada para la gestión de restos paleontológicos. La arquitectura de datos se basa en una relación jerárquica donde un **Esqueleto** agrupa múltiples piezas de **Fósiles**. El objetivo es permitir administrar tanto los especímenes completos (Esqueletos) como sus partes individuales (Fósiles).

## **2\. Objetivos de la Aplicación**

* **Gestión Jerárquica:** Administrar **Esqueletos** (información taxonómica y contextual) y sus **Fósiles** asociados (partes anatómicas específicas).  
* **Manejo de Estados Dual:** Controlar independientemente el `estado_esq` (del esqueleto completo, ej. "En Exhibición") y el `estado_fos` (de la pieza individual, ej. "Bajo estudio").  
* **Integridad Referencial:** Asegurar que todo fósil esté vinculado a un registro de esqueleto existente (relación `forma_parte_de`).

  ## **3\. Funcionalidades Principales**

La aplicación se dividirá en dos módulos principales interconectados: Gestión de Esqueletos y Gestión de Fósiles.

### **A. Módulo de Esqueletos (Entidad Padre)**

**1\. Registrar Esqueleto (Create):**

* Formulario para dar de alta un nuevo hallazgo o espécimen.  
* **Campos (según esquema):**  
  * `id_esq` (Autogenerado).  
  * `especie`: Especie a la que pertenece (ej. *Tyrannosaurus Rex*).  
  * `periodo`: Era geológica (ej. Cretácico Superior).  
  * `lugar`: Ubicación geográfica del hallazgo principal.  
  * `descripcion`: Detalles generales del espécimen.  
  * `fecha_esq`: Fecha de registro del conjunto.  
  * `estado_esq`: Estado general (ej. "En Exhibición", "Bajo Estudio").

**2\. Listado de Esqueletos (Read):**

* Vista maestra que muestra todos los esqueletos registrados.  
* Permite filtrar por `especie`, `periodo` o `lugar`.  
* **Acción:** Al seleccionar un esqueleto, se despliega la lista de fósiles asociados a él.

**3\. Editar/Exponer Esqueleto (Update):**

* Modificar datos generales (`descripcion`, `lugar`).  
* **Control de Exposición:** Cambiar el `estado_esq`.  
    ---

    ### **B. Módulo de Fósiles (Entidad Hija)**

**1\. Añadir Fósil a un Esqueleto (Create):**

* Formulario para ingresar una pieza ósea específica. **Debe seleccionarse previamente el Esqueleto al que pertenece.**  
* **Campos (según esquema):**  
  * `id_fos` (Autogenerado).  
  * `parte`: Nombre anatómico (ej. Fémur izquierdo, Cráneo).  
  * `fecha_fos`: Fecha de descubrimiento de esta pieza específica.  
  * `estado_fos`: Condición de la pieza (mismas opciones que esqueleto).  
  * *Relación:* Se asocia internamente al `id_esq` seleccionado.

**2\. Inventario de Fósiles (Read):**

* Tabla que muestra las piezas individuales.  
* Debe mostrar a qué esqueleto pertenece cada pieza.

**3\. Editar Estado de la Pieza (Update):**

* Permite actualizar el `estado_fos` o corregir la `parte`.  

**4\. Baja de Fósil (Delete):**

* Eliminación de un registro de fósil (borrado lógico o físico).  
* Esto elimina la pieza del inventario pero mantiene el registro del Esqueleto padre.

