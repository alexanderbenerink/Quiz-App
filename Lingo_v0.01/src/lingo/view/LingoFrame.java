package lingo.view;

import javax.swing.JFrame;
import javax.swing.JPanel;

import lingo.controller.LingoController;
import lingo.model.LingoModel;

public class LingoFrame extends JFrame {

	private static final long serialVersionUID = -5813866706772687578L;
	private int numbOfLetters;
	
	/**
	 * Frame waarop de applicatie zich afspeelt
	 * 
	 * Initialiseert de MVC objecten
	 */
	public LingoFrame() {
		setDefaultCloseOperation( EXIT_ON_CLOSE );
		numbOfLetters = 5;
		LingoView lingoView = new LingoView( numbOfLetters );
		LingoModel lingoModel = new LingoModel( numbOfLetters );
		new LingoController( lingoView, lingoModel, numbOfLetters );
		setPanel( lingoView );
	}
	
	/**
	 * Veranderd het huidige ContentPane
	 * @param panel: JPanel om weer te geven
	 */
	private void setPanel( JPanel panel ) {
		setContentPane( panel );
		validate();
	}

}




