package lingo.model;

import java.io.BufferedReader;
import java.io.FileReader;
import java.util.ArrayList;

public class LingoModel {
	
	private ArrayList<String> puzzleList;
	private String puzzle, puzzleHint;
	private int numbOfLetters;
	
	/**
	 * De Model klasse die de functionaliteiten van Lingo bevat
	 * 
	 * @param numbOfLetters: Hoeveelheid letters waarmee het spel gespeeld wordt
	 */
	public LingoModel( int numbOfLetters ) {
		this.numbOfLetters = numbOfLetters;
		puzzleList = new ArrayList<String>();
		createReader();
	}
	
	/**
	 * Initialiseert een BufferedReader object om een tekst bestand mee uit te kunnen lezen
	 * en roept vervolgens de functie aan om dat woord aan de lijst met puzzels toe te voegen 
	 */
	private void createReader() {
		String fileName = getFileName( numbOfLetters );
		try {
			FileReader file = new FileReader("words/" + fileName);
			BufferedReader reader = new BufferedReader( file );
			fillPuzzleList( reader );
			file.close();
		} catch ( Exception e ) {
			System.out.println( e.toString() );
		}
	}
	
	/**
	 * Haalt de naam van het tekstbestand die uitgelezen moet worden op
	 * 
	 * @param numbOfLetters: Hoeveelheid letters waarmee het spel gespeeld wordt
	 * @return: String met de naam van het bestand die uitgelezen moet worden
	 */
	private String getFileName( int numbOfLetters ) {
		String fileName = "";
		switch ( numbOfLetters ) {
			case 5: fileName = "5letterwoorden.txt";
			break;
			case 6: fileName = "6letterwoorden.txt";
			break;
		}
		return fileName;
	}
	
	/**
	 * Probeert het tekst bestand uit te lezen en wanneer mogelijk
	 * woorden aan de ArrayList met puzzels toe te voegen
	 * 
	 * @param reader: BufferedReader object waarmee woorden uitgelezen worden 
	 */
	private void fillPuzzleList( BufferedReader reader ) {
		try {
			String word = "";
			String line = reader.readLine();
			if ( line == null ) {
				throw new Exception( "no readable words found" );
			}
			while ( line != null ) {
				if ( ! line.isBlank() ) {
					word += line;
					puzzleList.add( word );
				}
				word = "";
				line = reader.readLine();
			}
		} catch ( Exception e ) {
			System.out.println( e.toString() );
		}
	}
	
	/**
	 * Genereert een willekeurig getal en kiest het het woord uit de ArrayList met
	 * puzzels met hetzelfde index nummer als actieve puzzel
	 * 
	 *  Creëert op basis van het gekozen woord ook de puzzel hint
	 */
	public void generatePuzzle() {
		int size = puzzleList.size();
		int number = (int)( Math.random() * size );
		puzzle = puzzleList.get( number );
		puzzleHint = puzzle.substring(0, 1);
		for ( int i = 1; i < numbOfLetters; i++ ) {
			puzzleHint += ".";
		}
	}
	
	/**
	 * Controleert of de invoer van de gebruiker gelijk staat
	 * aan de huidige puzzel
	 * 
	 * @param input: invoer van de gebruiker
	 * @return True wanneer gelijk, false wanneer ongelijk
	 */
	public boolean checkInput( String input ) {
		if ( puzzle.equals(input) ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Controleert welke letters van de invoer op de goede plek staan, verkeerde plek
	 * en welke letters er niet in voorkomen.
	 * 
	 * Hier heb ik het volgende voor verzonnen:
	 * 
	 * We houden twee tijdelijk Strings bij die gelijk staan aan de invoer en puzzel
	 * 
	 * 
	 * Stap 1 -> Vergelijk de invoer letter met de puzzel letter en controleer of ze gelijk staan
	 * 		     Zo ja, stop correct in de String[] met resultaten en muteer de tijdelijke puzzel string
	 * 
	 * Stap 2 -> Controleer of de input letter in de puzzel voorkomt 
	 * 			 Zo ja, sla deze letter tijdelijk op in een nieuwe String
	 * 
	 * Stap 3 -> Als de input letter niet in de puzzel voorkomt, stop incorrect in de String[] met resultaten
	 * 
	 * Stap 4 -> Controleer of de overgbleven letters uit stap 2 in de nieuwe tijdelijke puzzel string voorkomen
	 * 			 Zo ja, verwijder datzelfde letter uit de tijdelijke puzzel string zodat die niet nog een keer
	 * 			 meegeteld kan worden
	 * 
	 * @param input: String invoer van de gebruiker
	 * @return: String[] met de waardes correct, incorrect of misplaced
	 */
	public String[] getPuzzleResult( String input ) {
		String[] results = new String[numbOfLetters];
		String tempInputLetters = "";
		String tempPuzzleLetters = "";
		String correctLetters = "";
		for ( int i = 0; i < numbOfLetters; i++ ) {
			String inputLetter = input.substring(i, i+1);
			String puzzleLetter = puzzle.substring(i, i+1);
			// Stap 1
			if ( inputLetter.equals(puzzleLetter) ) {
				results[i] = "correct";
				tempInputLetters += ".";
				tempPuzzleLetters += ".";
				correctLetters += inputLetter;
			} 
			// Stap 2
			else if ( puzzle.contains(inputLetter) ) {
				tempInputLetters += inputLetter;
				tempPuzzleLetters += puzzleLetter;
				correctLetters += ".";
			}
			// Stap 3
			else {
				results[i] = "incorrect";
				tempInputLetters += ".";
				tempPuzzleLetters += puzzleLetter;
				correctLetters += ".";
			}
		}
		updatePuzzleHint( correctLetters );
		// Stap 4
		for ( int i = 0; i < numbOfLetters; i++ ) {
			String inputLetter = tempInputLetters.substring(i, i+1);
			if ( ! inputLetter.equals(".") ) {
				if ( stringContains( inputLetter, tempPuzzleLetters ) ) {
					results[i] = "misplaced";
					tempPuzzleLetters = tempPuzzleLetters.replaceFirst( inputLetter, ".");
				} else {
					results[i] = "incorrect";
				}
			} 
		}
		return results;
	}
	
	/**
	 * Creëert een nieuwe puzzel hint String op basis van de String die binnenkomt
	 * 
	 * @param input: String met nieuwe puzzel hint
	 */
	private void updatePuzzleHint( String input ) {
		String newPuzzleHint = puzzleHint.substring(0, 1);
		for ( int i = 1; i < numbOfLetters; i++ ) {
			String inputLetter = input.substring(i, i+1);
			String puzzleHintLetter = puzzleHint.substring(i, i+1);
			if ( ! inputLetter.equals(".") ) {
				if ( puzzleHintLetter.equals(".") ) {
					newPuzzleHint += inputLetter;
				} else {
					newPuzzleHint += puzzleHintLetter;
				}
			} else {
				newPuzzleHint += puzzleHintLetter;
			}
		}
		setPuzzleHint( newPuzzleHint );
	}
	
	/**
	 * Controleert of de letter die binnenkomt voorkomt in de String die binnenkomt 
	 * 
	 * @param letter: De letter waarnaar gecontroleerd moet worden
	 * @param puzzle: De String waarin gecontroleerd moet worden
	 * 
	 * @return: True wanneer het voorkomt, false wanneer het niet voorkomt
	 */
	private boolean stringContains( String letter, String puzzleRemains ) {
		if ( puzzleRemains.contains(letter) ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Getter voor de variabel puzzle
	 * 
	 * @return: String met de huidige puzzel
	 */
	public String getPuzzle() {
		return puzzle;
	}
	
	/**
	 * Getter voor de variabel puzzleHint
	 * 
	 * @return: String met de huidige puzzel hint
	 */
	public String getPuzzleHint() {
		return puzzleHint;
	}
	
	/**
	 * Setter voor de variabel puzzelHint
	 * 
	 * @param puzzleHint: String met de nieuwe puzzel hint
	 */
	public void setPuzzleHint( String puzzleHint ) {
		this.puzzleHint = puzzleHint;
	}
	
	/**
	 * Wordt alleen gebruikt voor de test klasse LingoTest
	 * @param puzzle: Puzzel die binnenkomt
	 */
	public void setPuzzle( String puzzle ) {
		this.puzzle = puzzle;
	}
	
}
