package lingo.view;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.event.ActionListener;
import java.util.ArrayList;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class LingoView extends JPanel {

	private static final long serialVersionUID = 1512667815183731706L;
	private JPanel lingoPanel, inputPanel, playerInfoPanel, playerInfoContainer;
	private GridLayout gridLayout;
	private JTextField inputField, scoreField, totalPuzzleField, correctPuzzleField, incorrectPuzzleField;
	private JButton inputButton;
	private ArrayList<JTextField> textFieldList;
	private int numbOfLetters, gridCount;
	
	/**
	 * JPanel waar alle grafische weergaves bij elkaar komen
	 * De drie weergaves zijn JPanels voor Lingo, spel informatie en gebruikers interface
	 * 
	 * @param numbOfLetters: Hoeveelheid letters waarmee het spel gespeeld wordt
	 */
	public LingoView( int numbOfLetters ) {
		setLayout( new BorderLayout() );
		this.numbOfLetters = numbOfLetters;
		gridCount = 5 * numbOfLetters;
		initLingoPanel();
		initInputPanel();
		initPlayerInfoPanel();
	}
	
	/**
	 * Initialiseert en vult het JPanel object waar het Lingo spel zicht op afspeelt
	 */
	private void initLingoPanel() {
		lingoPanel = new JPanel();
		gridLayout = new GridLayout(5, numbOfLetters);
		lingoPanel.setLayout( gridLayout );
		lingoPanel.setBackground( new Color( 0, 128, 255) );
		textFieldList = new ArrayList<JTextField>();
		for ( int i = 0; i < gridCount; i++ ) {
			addTextField();
		}
		add( lingoPanel, BorderLayout.CENTER );
	}
	
	/**
	 * Geeft een JTextField object terug waarmee lingo woorden weergegeven kunnen worden
	 * 
	 * @return Een JTextField object voor Lingo woorden
	 */
	public JTextField createTextField() {
		JTextField textField = new JTextField();
		textField.setEditable( false );
		textField.setHorizontalAlignment( JTextField.CENTER );
		textField.setFont( new Font("San-Sarif", Font.BOLD, 25) );
		textField.setBackground( null );
		textField.setBorder( BorderFactory.createLineBorder( Color.GRAY, 2) );
		return textField;
	}
	
	/**
	 * Voegt een JTextField object toe aan de lijst met JTextFields en vervolgens aan het paneel
	 */
	public void addTextField() {
		JTextField textField = createTextField();
		textFieldList.add( textField );
		lingoPanel.add( textField );
	}
	
	/**
	 * Verwijdert het laatste JTextField object uit de lijst met JTextFields en ook uit het paneel
	 */
	public void removeTextField() {
		lingoPanel.remove( textFieldList.size() - 1 );
		textFieldList.remove( textFieldList.size() - 1 );
	}
	
	/**
	 * Kleurt een JTextField in
	 * 
	 * @param index: Index nummer van het JTextField object in de ArrayList
	 * @param color: Kleur die het JTextField object moet gaan krijgen
	 */
	public void colorTextField( int index, Color color ) {
		textFieldList.get(index).setBackground( color );
	}
	
	/**
	 * Geeft elke letter van de puzzel in een JTextField object weer
	 * 
	 * @param puzzle: Puzzel die weergegeven moet worden
	 * @param row: Rij nummer waar het invullen moet beginnen
	 */
	public void displayPuzzle( String puzzle, int row ) {
		for ( int i = 0; i < numbOfLetters; i++ ) {
			String letter = puzzle.substring(i, i+1);
			textFieldList.get(row+i).setText( letter );
		}
	}
	
	/**
	 * Verwijdert de tekst van een JTextField object
	 * 
	 * @param index: Index nummer van het JTextField object in de ArrayList
	 */
	public void clearTextField( int index ) {
		textFieldList.get(index).setText("");
	}
	
	/**
	 * Past de hoeveelheid rijen in het GridLayout object aan
	 * 
	 * @param row: Hoeveelheid rijen waarnaar verandert wordt
	 */
	public void setRows( int row ) {
		gridLayout.setRows( row );
	}
	
	/**
	 * Valideert de componenten binnen dit paneel
	 */
	public void validateContent() {
		validate();
	}
	
	/**
	 * Initialiseert en vult het JPanel object voor de gebruikersinterface 
	 */
	private void initInputPanel() {
		inputPanel = new JPanel();
		inputPanel.setLayout( new GridLayout(1, 2) );
		inputField = new JTextField();
		inputField.setEditable( false );
		inputField.setFont( new Font("San-Sarif", Font.BOLD, 18) );
		inputButton = new JButton( "Next Word" );
		inputPanel.add( inputField );
		inputPanel.add( inputButton );
		add( inputPanel, BorderLayout.SOUTH );
	}
	
	/**
	 * Haalt de tekst uit het invoer veld op
	 * 
	 * @return: Invoer van de gebruiker
	 */
	public String getInput() {
		String input = inputField.getText();
		return input;
	}
	
	/**
	 * Voegt een ActionListener toe aan de invoer knop
	 * 
	 * @param actionListener: Een ActionListener
	 */
	public void addButtonHandler( ActionListener actionListener ) {
		inputButton.addActionListener( actionListener );
	}
	
	/**
	 * Verwijdert een ActionListener van de invoer knop
	 * 
	 * @param actionListener
	 */
	public void removeButtonHandler( ActionListener actionListener ) {
		inputButton.removeActionListener( actionListener );
	}
	
	/**
	 * Voegt een ActionListener toe aan het invoer veld
	 * 
	 * @param actionListener: Een ActionListener
	 */
	public void addTextFieldHandler( ActionListener actionListener ) {
		inputField.addActionListener( actionListener );
	}
	
	/**
	 * Zet de invoer knop op actief of inactief
	 * 
	 * @param bool: True wanneer actief, false wanneer inactief
	 */
	public void toggleButton( boolean bool ) {
		inputButton.setEnabled( bool );
	}
	
	/**
	 * Zet het invoer veld op actief of inactief
	 * @param bool: True wanneer actief, false wanneer inactief
	 */
	public void toggleTextField( boolean bool ) {
		inputField.setEditable( bool );
	}
	
	/**
	 * Verwijdert de tekst van het invoer vak
	 */
	public void clearInputField() {
		inputField.setText("");
	}
	
	/**
	 * Initialiseert het JPanel object voor de informatie van het verloop van het spel
	 */
	private void initPlayerInfoPanel() {
		playerInfoPanel = new JPanel();
		playerInfoContainer = new JPanel();
		playerInfoContainer.setLayout( new GridLayout(8, 1) );
		totalPuzzleField = createInfoTextField();
		correctPuzzleField = createInfoTextField();
		incorrectPuzzleField = createInfoTextField();
		scoreField = createInfoTextField();
		playerInfoContainer.add( new JLabel("Total puzzles:") );
		playerInfoContainer.add( totalPuzzleField );
		playerInfoContainer.add( new JLabel("Correct:") );
		playerInfoContainer.add( correctPuzzleField );
		playerInfoContainer.add( new JLabel("Incorrect:") );
		playerInfoContainer.add( incorrectPuzzleField );
		playerInfoContainer.add( new JLabel("Score: ") );
		playerInfoContainer.add( scoreField );
		playerInfoPanel.add( playerInfoContainer );
		add( playerInfoPanel, BorderLayout.WEST );
	}
	
	/**
	 * Geeft een JTextField object terug
	 * 
	 * @return: JTextField object voor gebruik in het informatie paneel
	 */
	private JTextField createInfoTextField() {
		JTextField textField = new JTextField( 5 );
		textField.setHorizontalAlignment( JTextField.CENTER );
		textField.setEditable( false );
		return textField;
	}
	
	/**
	 * Verandert de tekst van het JTextField object waarmee de hoeveelheid correct geraden
	 * puzzels weergegeven wordt
	 * 
	 * @param correctPuzzles: Hoeveelheid aan correct geraden puzzels
	 */
	public void displayCorrectPuzzles( String correctPuzzles ) {
		correctPuzzleField.setText( correctPuzzles );
	}
	
	/**
	 * Verandert de tekst van het JTextField object waarmee de hoeveelheid incorrect geraden
	 * puzzels weergegeven wordt
	 * 
	 * @param incorrectPuzzles: Hoeveelheid aan incorrect geraden puzzels
	 */
	public void displayIncorrectPuzzles( String incorrectPuzzles ) {
		incorrectPuzzleField.setText( incorrectPuzzles );
	}
	
	/**
	 * Verandert de tekst van het JTextField object waarmee het totaal aantal gespeelde puzzels
	 * weergegeven wordt.
	 * 
	 * @param totalPuzzles: Totaal aantal gespeelde puzzels
	 */
	public void displayTotalPuzzles( String totalPuzzles ) {
		totalPuzzleField.setText( totalPuzzles );
	}
	
	/**
	 * Verandert de tekst van het JTextField object waarme de score weergegeven wordt
	 * 
	 * @param score: Totale score
	 */
	public void displayScore( String score ) {
		scoreField.setText( score );
	}
	
}
