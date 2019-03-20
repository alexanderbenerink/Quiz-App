package lingo.main;

import java.awt.Dimension;

import lingo.test.LingoTest;
import lingo.view.LingoFrame;

/**
 * Lingo Game
 * 
 * @author Emile
 * @version v0.01
 */
public class LingoGame {
	
	/**
	 * Main. De applicatie begint hier.
	 * 
	 * @param args
	 */
	public static void main( String[] args ) {
		LingoFrame lingoFrame = new LingoFrame();
		lingoFrame.setTitle( "Lingo Game v0.01" );
		lingoFrame.setMinimumSize( new Dimension( 500, 500 ) );
		lingoFrame.setVisible( true );
		// lingoTest = new LingoTest();
	}
	
}



