package lingo.controller;

import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import lingo.model.LingoModel;
import lingo.view.LingoView;

public class LingoController {
	
	private LingoView lingoView;
	private LingoModel lingoModel;
	private ActionListener startGame, continueGame;
	private int numbOfLetters, turn, textFieldPosition, score, totalPuzzles, correctPuzzles, incorrectPuzzles;
	private final static int POINTS = 25;
	private boolean isFirstPuzzle;
	
	/**
	 * De Controller klasse die het verloop van het spel beheert
	 * 
	 * @param lingoView: LingoView object voor het weergegeven van visuele feedback
	 * @param lingoModel: LingoModel object voor de functionaliteit van Lingo
	 * @param numbOfLetters: Hoeveelheid letters waarmee het spel gespeeld wordt
	 */
	public LingoController( LingoView lingoView, LingoModel lingoModel, int numbOfLetters ) {
		this.lingoView = lingoView;
		this.lingoModel = lingoModel;
		this.numbOfLetters = numbOfLetters;
		totalPuzzles = 0;
		correctPuzzles = 0;
		incorrectPuzzles = 0;
		score = 0;
		isFirstPuzzle = true;
		displayInfo();
		addListeners();
	}
	
	/**
	 * Geeft het LingoView object opdrachten om informatie over het verloop van het spel weer te geven
	 */
	private void displayInfo() {
		lingoView.displayTotalPuzzles( totalPuzzles + "" );
		lingoView.displayCorrectPuzzles( correctPuzzles + "" );
		lingoView.displayIncorrectPuzzles( incorrectPuzzles + "" );
		lingoView.displayScore( score + "" );
	}
	
	/**
	 * Start een nieuwe puzzel
	 */
	private void startPuzzle() {
		lingoView.toggleButton( false );
		turn = 0;
		lingoModel.generatePuzzle();
		nextTurn();
	}
	
	/**
	 * Beheert het verloop van een beurt
	 * 
	 * Zet de puzzel voort wanneer de gebruiker nog pogingen over heeft en laat
	 * anders de correcte puzzel zien en eindigt de beurt
	 * 
	 */
	private void nextTurn() {
		turn++;
		textFieldPosition = getTextFieldPosition( turn );
		if ( turn <= 5 ) {
			String puzzleHint = lingoModel.getPuzzleHint();
			lingoView.displayPuzzle( puzzleHint, textFieldPosition );
			lingoView.toggleTextField( true );
		} else {
			lingoView.setRows( 6 );
			for ( int i = 0; i < numbOfLetters; i++ ) {
				lingoView.addTextField();
				lingoView.colorTextField( textFieldPosition + i, new Color( 244, 75, 35) );
			}
			lingoView.validateContent();
			lingoView.displayPuzzle( lingoModel.getPuzzle(), textFieldPosition );
			incorrectPuzzles++;
			lingoView.displayIncorrectPuzzles( incorrectPuzzles + "" );
			endPuzzle();
		}
	}
	
	/**
	 * Geeft de positie van het eerste tekst vak in een rij terug
	 * 
	 * Hiervoor heb ik het volgende verzonnen:
	 * 
	 * Als we met 5 letters spelen ziet het veld er als volgt uit:
	 * Het nummer refereert naar in de index van het tekst vak in de ArrayList
	 * 
	 *  0....
	 *  5....
	 * 10....
	 * 15....
	 * 20....
	 * 
	 * Met de formule "( aantal letters * huidge beurt ) - aantal letters" kom je altijd
	 * op de rij uit die gelijk staat aan de huidige beurt.
	 * 
	 * @param turn: huidige beurt om de correcte rij mee op te zoeken
	 * @return: int waarde die refereert naar de positie van het eerste tekst vak in een rij
	 */
	public int getTextFieldPosition( int turn ) {
		int position = (numbOfLetters * turn) - numbOfLetters;
		return position;
	}
	
	/**
	 * Haalt de invoer uit het invoer vak op
	 * 
	 * @return: String die de tekst van het invoer vak bevat
	 */
	private String collectInput() {
		String input = lingoView.getInput().toLowerCase();
		lingoView.clearInputField();
		return input;
	}
	
	/**
	 * Controleert of de invoer van de gebruiker gelijk staat aan de huidige puzzel
	 * en spreekt het LingoView object aan om feedback weer te geven
	 * 
	 * True: Beëindig de puzzel
	 * False: Zet de volgende poging van gang 
	 * 
	 * @param input: Invoer van de gebruiker
	 */
	private void manageInput( String input ) {
		lingoView.displayPuzzle( input, textFieldPosition );
		Color red = new Color( 244, 75, 35);
		if ( lingoModel.checkInput( input ) ) {
			for ( int i = 0; i < numbOfLetters; i++ ) {
				lingoView.colorTextField( textFieldPosition + i, red );
			}	
			setScore( POINTS );
			correctPuzzles++;
			lingoView.displayScore( score + "" );
			lingoView.displayCorrectPuzzles( correctPuzzles + "" );
			endPuzzle();
		} else {
			String[] results = lingoModel.getPuzzleResult(input);
			Color yellow = new Color( 255, 255, 51 );
			for ( int i = 0; i < numbOfLetters; i++ ) {
				String result = results[i];
				if ( result.equals("correct") ) {
					lingoView.colorTextField( textFieldPosition + i, red );
				} else if ( result.equals("misplaced") ) {
					lingoView.colorTextField( textFieldPosition + i, yellow );
				}
			}
			nextTurn();
		}
	}
	
	/**
	 * Setter voor de int variabel score
	 * 
	 * @param points: Hoeveelheid punten om toe te voegen 
	 */
	private void setScore( int points ) {
		this.score += points;
	}
	
	/**
	 * Beëindigt de puzzel en verwisselt een ActionListener
	 * alleen na het spelen van de eerste puzzel
	 */
	private void endPuzzle() {
		lingoView.toggleTextField( false );
		lingoView.toggleButton( true );
		totalPuzzles++;
		lingoView.displayTotalPuzzles( totalPuzzles + "" );
		if ( isFirstPuzzle ) {
			lingoView.removeButtonHandler( startGame );
			lingoView.addButtonHandler( continueGame );
			startGame = null;
			isFirstPuzzle = false;
		}
	}
	
	/**
	 * Initialiseert anonieme ActionListeners en voegt deze toe 
	 * aan de invoer objecten in het LingoView object
	 */
	private void addListeners() {
		/**
		 * De startGame ActionListener object wordt alleen gebruikt voor het starten 
		 * van de eerste puzzelen wordt daarna op null gezet
		 */
		startGame = new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				startPuzzle();
				startGame = null;
			}
		};
		/**
		 * De continueGame ActionListener object neemt na de eerste puzzel
		 * het werk van het startGame object over
		 * 
		 * Wat dit object extra doet is het aanspreken van het LingoView object om alle JTextField objecten
		 * van het lingoPanel object die gemuteerd zijn terug te zetten naar de originele staat.
		 */
		continueGame = new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				for ( int i = 0; i < turn; i++ ) {
					textFieldPosition = getTextFieldPosition( i + 1 );
					for ( int n = 0; n < numbOfLetters; n++ ) {
						lingoView.colorTextField( textFieldPosition + n, null );
						lingoView.clearTextField( textFieldPosition + n );
					}
				}
				if ( turn > 5 ) {
					for ( int i = 0; i < numbOfLetters; i++ ) {
						lingoView.removeTextField();
					}
				}
				lingoView.setRows( 5 );
				lingoView.validateContent();
				lingoView.toggleTextField( false );
				startPuzzle();
			}
		};
		lingoView.addButtonHandler( startGame );
		/**
		 * Anonieme ActionListener die de invoer van de gebruiker afhandelt
		 */
		lingoView.addTextFieldHandler( new ActionListener( ) {
			@Override
			public void actionPerformed(ActionEvent e) {
				try {
					String input = collectInput();
					if ( input.isBlank() ) {
						throw new Exception( "input required" );
					} else if ( input.length() < numbOfLetters ) {
						throw new Exception( "input has less than " + numbOfLetters + " characters" );
					}
					manageInput( input );
				} catch ( Exception exception ) {
					System.out.println( exception.toString() );
				}
			}
		});
	}
	
}
