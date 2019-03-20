package lingo.test;

import lingo.model.LingoModel;

/**
 * Klasse om Lingo mee te testen
 *
 */
public class LingoTest {
	
	private LingoModel lingoModel;
	private static final int NUMB_OF_LETTERS = 5;
	private String puzzle = "hallo";
	private String input = "hella";
	
	public LingoTest() {
		lingoModel = new LingoModel( NUMB_OF_LETTERS );
		lingoModel.setPuzzle( puzzle );
		lingoModel.setPuzzleHint( puzzle );
		if ( lingoModel.checkInput(input) ) {
			System.out.println( "Woord goed geraden." );
		} else {
			for ( int i = 0; i < NUMB_OF_LETTERS; i++ ) {
				System.out.println( lingoModel.getPuzzleResult(input)[i] );
			}
		}
		
	}
	
}
