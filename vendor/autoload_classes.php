<?php

# Classe de Configurações
include __SITE_PATH . '/app/config.class.php';

# Classe de Registros
include __SITE_PATH . '/app/db.class.php';

# Classe de Registros
include __SITE_PATH . '/app/registry.class.php';

# Classe base dos controllers
include __SITE_PATH . '/app/controller_base.class.php';

# Classe dos routers
include __SITE_PATH . '/app/router.class.php';

# Classe do template
include __SITE_PATH . '/app/template.class.php';

# Classe do Resize
require_once __DIR__ . '/resize' . '/resize.class.php';

$registry = new mktInstagram\Registry();
