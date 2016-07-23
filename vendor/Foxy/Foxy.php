<?php

	/*
	* Foxy.php
	* @Auteur : Christophe Dufour
	* 
	* Mon moteur de template
	*
	*/
	
	/* Définition de la classe */
	final class Foxy {
		
		// Chemain vers le dossier contenant les templates
		private $dossierDesTemplates;
		
		// Le template dont le contenue doit être généré et affiché
		private $template;
		
		// Tableau des variables
		private $variables = array(null);
		
		// 
		private $afficherLesErreurs = true;
		
		// Constructeur de classe
		public function __construct($dossier = null) {
			if(!is_null($dossier)) {
				$this->setDossierDesTemplates($dossier);
			}
		}
		
		// Modifie le chemin vers le dossier contenant les templates
		public function setDossierDesTemplates($dossier) {
			if(is_array($dossier)) {
				foreach($dossier as $chemin) {
					if(is_dir($chemin) && is_readable($chemin)) {
						$this->dossierDesTemplates[] = $chemin;
					}
					else {
						// throw new Exception("");
						exit("Impossible d'accéder au dossier : '$chemin'.");
					}
				}
			}
			else {
				if(is_dir($dossier) && is_readable($dossier)) {
					$this->dossierDesTemplates = $dossier;
				}
				else {
					// throw new Exception("");
					exit("Impossible d'accéder au dossier : '$dossier'.");
				}
			}
		}
		
		// Modifie les paramètres d'affichages des données du template
		public function setConf($afficherLesErreurs) {
			$this->afficherLesErreurs = $afficherLesErreurs;
		}
		
		// Charge un fichier contenant un template
		public function load($fichier, $ajouter = true) {
			$fichierTrouve = false;
			
			if(is_array($this->dossierDesTemplates)) {
				foreach($this->dossierDesTemplates as $dossier) {
					$fichierTemplate = $dossier . $fichier;
					
					if(is_file($fichierTemplate) && is_readable($fichierTemplate)) {
						$fichierTrouve = true;
						
						if($ajouter) {
							$this->template .= file_get_contents($fichierTemplate);
						}
						else {
							$this->template = file_get_contents($fichierTemplate);
						}
						
						break;
					}
				}
			}
			else {
				$fichierTemplate = $this->dossierDesTemplates . $fichier;
				
				if(is_file($fichierTemplate) && is_readable($fichierTemplate)) {
					$fichierTrouve = true;
					
					if($ajouter) {
						$this->template .= file_get_contents($fichierTemplate);
					}
					else {
						$this->template = file_get_contents($fichierTemplate);
					}
				}
			}
			
			if(!$fichierTrouve)
					exit("Impossible d'ouvrir le fichier : '$fichier'.");
		}
		
		// Permet de definir une variable interne pour le template
		public function set($variable, $valeur = null) {
			// Motif de recherche.
			$pattern = "#[a-zA-Z][a-zA-Z0-9_]*#";
			
			if(is_array($variable)) {
				foreach($variable as $key => $valeur) {
					if(preg_match($pattern, $key)) {
						$this->variables[$key] = $valeur;
					}
				}
			}
			else {
				if(preg_match($pattern, $variable)) {
					$this->variables[$variable] = $valeur;
				}
			}
		}
		
		// Analyse et retourne le template
		public function render(array $donnees = null) {
			if(!is_null($donnees)) {
				$this->variables = array_merge($this->variables, $donnees);
			}
			
			return $this->analyser($this->template);
		}
		
		// Retourne l'objet sous forme de chaine de caractère
		public function __toString() {
			return $this->template;
		}
		
		// Lance les différentes analyses du template
		private function analyser($template) {
			$template = $this->analyserBoucleFor($template);
			$template = $this->analyserForeach($template);
			$template = $this->analyserConditions($template);
			$template = $this->analyserVariables($template);
			
			return $template;
		}
		
		// Analyse le template pour voir si des variables sont à remplacer
		private function analyserVariables($template) {
			$motif = "#\{\{\s*([a-zA-Z][a-zA-Z0-9_]*)\s*(:html)?\s*\}\}#";
			
			$template = preg_replace_callback($motif, array($this, 'remplacerVariables'), $template);
			
			$motif = "#\{\{\s*([a-zA-Z][a-zA-Z0-9_]*\.[a-zA-Z0-9_]+)\s*(:html)?\s*\}\}#";
			
			$template = preg_replace_callback($motif, array($this, 'remplacerVariablesSpecials'), $template);
			
			return $template;
		}
		
		// Remplace dans le template des variables par leurs valeurs
		private function remplacerVariables($matches) {
			if(array_key_exists($matches[1], $this->variables)) {
				if(isset($matches[2]) && $matches[2] == ":html")
					return $this->variables[$matches[1]];
				
				return htmlspecialchars($this->variables[$matches[1]], ENT_QUOTES, 'UTF-8', false);
			}
			
			if($this->afficherLesErreurs)
				return "#NON DEFINIT '$matches[0]'#";
			
			return "";
		}
		
		// Remplace dans le template des variables de tableaux ou d'objets par leurs valeurs
		private function remplacerVariablesSpecials($matches) {
			$tab = explode(".", $matches[1]);
			
			if(array_key_exists($tab[0], $this->variables)) {
				
				if(is_array($this->variables[$tab[0]]))
					$valeur = $this->variables[$tab[0]][$tab[1]];
				
				if(is_object($this->variables[$tab[0]])) {
					if(method_exists($this->variables[$tab[0]], $tab[1]))
						$valeur = $this->variables[$tab[0]]->$tab[1]();
				}
				
				if(isset($valeur)) {
					if(isset($matches[2]) && $matches[2] == ":html")
						return $valeur;
					
					return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
				}
			}
			
			if($this->afficherLesErreurs)
				return "#NON DEFINIT '$matches[0]'#";
			
			return "";
		}
		
		// Analyse le template pour voir si des conditions sont à évaluer
		private function analyserConditions($template) {
			// Structure générale d'un if.
			$pattern  = "#\{\%\s*if\s*\(\s*";
			
			$pattern .= "(([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)";
			
			$pattern .= "|(([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)";
			$pattern .= "\s*(==|!=|<|<=|>|>=)\s*";
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)))";
			
			$pattern .= "\s*\)\s*\%\}.*";
			$pattern .= "(\{\%\s*else\s*\%\}.*)?";
			$pattern .= "\{\%\s*endif\s*\%\}#sU";
			
			$template = preg_replace_callback($pattern, array($this, 'remplacerConditionsSwitch'), $template);
			
			return $template;
		}
		
		// 
		private function remplacerConditionsSwitch($matches) {
			$pattern  = "#\{\%\s*if\s*\(\s*";
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)";
			$pattern .= "\s*\)\s*\%\}(.*)";
			$pattern .= "(\{\%\s*else\s*\%\}(.*))?";
			$pattern .= "\{\%\s*endif\s*\%\}#sU";
			
			if(preg_match($pattern, $matches[0]))
				return preg_replace_callback($pattern, array($this, 'remplacerConditions1'), $matches[0]);
			
			$pattern  = "#\{\%\s*if\s*\(\s*";
			
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)";
			$pattern .= "\s*(==|!=|<|<=|>|>=)\s*";
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*|[0-9]+)";
			
			$pattern .= "\s*\)\s*\%\}(.*)";
			$pattern .= "(\{\%\s*else\s*\%\}(.*))?";
			$pattern .= "\{\%\s*endif\s*\%\}#sU";
			
			if(preg_match($pattern, $matches[0]))
				return preg_replace_callback($pattern, array($this, 'remplacerConditions2'), $matches[0]);
		}
		
		// Retourne la bonne évaluation d'une condition
		private function remplacerConditions1($matches) {
			if(is_numeric($matches[1])) {
				$op = (int) $matches[1];
			}
			else {
				if(!array_key_exists($matches[1], $this->variables)) {
					if($this->afficherLesErreurs)
					return "#NON DEFINIT '$matches[0]'#";
					
					return "";
				}
				
				$op = $this->variables[$matches[1]];
			}
			
			if(!empty($op))
				return $matches[2];
			
			if(isset($matches[3]))
				return $matches[4];
			
			return "";
		}
		
		// Retourne la bonne évaluation d'une condition
		private function remplacerConditions2($matches) {
			if(!is_numeric($matches[1])) {
				if(!array_key_exists($matches[1], $this->variables)) {
					if($this->afficherLesErreurs)
					return "#NON DEFINIT '$matches[0]'#";
					
					return "";
				}
				
				$op1 = $this->variables[$matches[1]];
			}
			else {
				$op1 = (int) $matches[1];
			}
			
			if(!is_numeric($matches[3])) {
				if(!array_key_exists($matches[3], $this->variables)) {
					if($this->afficherLesErreurs)
					return "#NON DEFINIT '$matches[0]'#";
					
					return "";
				}
				
				$op2 = $this->variables[$matches[3]];
			}
			else {
				$op2 = (int) $matches[3];
			}
				
			switch($matches[2]) {
				case "<" : {
					if($op1 < $op2)
						return $matches[4];
				} break;
				
				case "<=" : {
					if($op1 <= $op2)
						return $matches[4];
				} break;
				
				case "==" : {
					if($op1 == $op2)
						return $matches[4];
				} break;
				
				case "!=" : {
					if($op1 != $op2)
						return $matches[4];
				} break;
				
				case ">=" : {
					if($op1 >= $op2)
						return $matches[4];
				} break;
				
				case ">" : {
					if($op1 > $op2)
						return $matches[4];
				} break;
			}
			
			if(isset($matches[5]))
				return $matches[6];
			
			return "";
		}
		
		
		// Analyse le template pour voir si des boules for sont à remplacer
		private function analyserBoucleFor($template) {
			// Structure générale d'une bouble for.
			$pattern  = "#\{\%\s*for\s*\(\s*";
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*)\s+in\s+([0-9]+)\.\.([0-9]+)";
			$pattern .= "\s*\)\s*\%\}(.*)";
			$pattern .= "\{\%\s*endfor\s*\%\}#sU";
			
			$template = preg_replace_callback($pattern, array($this, 'remplacerBoucleFor'), $template);
			
			return $template;
		}
		
		// Remplace un bloucle for
		private function remplacerBoucleFor($matches) {
			$contenu = null;
			
			for($this->variables[$matches[1]]=$matches[2]; $this->variables[$matches[1]] <= $matches[3];
				$this->variables[$matches[1]]++) {
					$contenuTmp = $this->analyserConditions($matches[4]);
					$contenuTmp = $this->analyserVariables($contenuTmp);
					
					$contenu .= $contenuTmp;
			}
			
			return $contenu;
		}
		
		// Analyse le template pour voir si des structures foreach sont à remplacer
		private function analyserForeach($template) {
			// Structure générale d'un foreach.
			$pattern  = "#\{\%\s*foreach\s*\(\s*";
			$pattern .= "([a-zA-Z][a-zA-Z0-9_]*)\s+as\s+([a-zA-Z][a-zA-Z0-9_]*)";
			$pattern .= "\s*\)\s*\%\}(.*)";
			$pattern .= "\{\%\s*endforeach\s*\%\}#sU";
			
			$template = preg_replace_callback($pattern, array($this, 'remplacerForeach'), $template);
			
			return $template;
		}
		
		// Remplace un structure foreach d'un template
		private function remplacerForeach($matches) {
			$contenu = null;
			
			if(array_key_exists($matches[1], $this->variables)) {
				foreach($this->variables[$matches[1]] as $this->variables[$matches[2]]) {
					$contenuTmp = $this->analyserConditions($matches[3]);
					$contenuTmp = $this->analyserVariables($contenuTmp);
					
					$contenu .= $contenuTmp;
				}
				
				return $contenu;
			}
			
			if($this->afficherLesErreurs)
				return "#NON DEFINIT '$matches[0]'#";
			
			return "";
		}
	
	}