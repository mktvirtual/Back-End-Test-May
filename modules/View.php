<?php
namespace HojePromete;
interface iView
{
	public function __construct($template,$value);
	public function assign($data);
	public function setVariable($name, $var);
	public function getHtml($template);
}

class View implements iView
{
	protected $template = null;
	protected $value = null;
	private $vars = array();
	public function __construct($template,$value)
	{
		$this->template = $template;
		$this->value = $value;
	}
	public function assign($data)
	{
		return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
	}

	public function setVariable($name, $var)
	{
		$this->vars[$name] = $var;
	}
	public function getHtml($template)
	{
		foreach($this->vars as $name => $value)
		{
			$template = str_replace('{' . $name . '}', $value, $template);
		}
		return $template;
	}
	private function renderContent()
	{
		ob_start();
		include($this->value);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	private function renderTemplate()
	{
		ob_start();
		include($this->template);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function render()
	{
		$this->value = $this->renderContent();
		$template = $this->renderTemplate();
		echo $template;
	}

}
?>
