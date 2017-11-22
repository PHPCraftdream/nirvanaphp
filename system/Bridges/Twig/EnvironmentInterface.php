<?php

namespace PHPCraftdream\NirvanaPHP\Bridges\Twig {

	use Twig_ExtensionInterface;
	use Twig_LoaderInterface;
	use Twig_NodeVisitorInterface;
	use Twig_RuntimeLoaderInterface;
	use Twig_TokenParserInterface;
	use Twig_TokenStream;

	interface EnvironmentInterface {
		public function __construct(Twig_LoaderInterface $loader = null, $options = array());

		public function getBaseTemplateClass();

		public function setBaseTemplateClass($class);

		public function enableDebug();

		public function disableDebug();

		public function isDebug();

		public function enableAutoReload();

		public function disableAutoReload();

		public function isAutoReload();

		public function enableStrictVariables();

		public function disableStrictVariables();

		public function isStrictVariables();

		public function getCache($original = true);

		public function setCache($cache);

		public function getCacheFilename($name);

		public function getTemplateClass($name, $index = null);

		public function getTemplateClassPrefix();

		public function render($name, array $context = array());

		public function display($name, array $context = array());

		public function load($name);

		public function loadTemplate($name, $index = null);

		public function createTemplate($template);

		public function isTemplateFresh($name, $time);

		public function resolveTemplate($names);

		public function clearTemplateCache();

		public function clearCacheFiles();

		public function getLexer();

		public function tokenize($source, $name = null);

		public function getParser();

		public function parse(Twig_TokenStream $stream);

		public function getCompiler();

		public function compileSource($source, $name = null);

		public function setLoader(Twig_LoaderInterface $loader);

		public function getLoader();

		public function setCharset($charset);

		public function getCharset();

		public function initRuntime();

		public function hasExtension($class);

		public function addRuntimeLoader(Twig_RuntimeLoaderInterface $loader);

		public function getExtension($class);

		public function getRuntime($class);

		public function addExtension(Twig_ExtensionInterface $extension);

		public function removeExtension($name);

		public function setExtensions(array $extensions);

		public function getExtensions();

		public function addTokenParser(Twig_TokenParserInterface $parser);

		public function getTokenParsers();

		public function getTags();

		public function addNodeVisitor(Twig_NodeVisitorInterface $visitor);

		public function getNodeVisitors();

		public function addFilter($name, $filter = null);

		public function getFilter($name);

		public function registerUndefinedFilterCallback($callable);

		public function getFilters();

		public function addTest($name, $test = null);

		public function getTests();

		public function getTest($name);

		public function addFunction($name, $function = null);

		public function getFunction($name);

		public function registerUndefinedFunctionCallback($callable);

		public function getFunctions();

		public function addGlobal($name, $value);

		public function getGlobals();

		public function mergeGlobals(array $context);

		public function getUnaryOperators();

		public function getBinaryOperators();

		public function computeAlternatives($name, $items);
	}
}