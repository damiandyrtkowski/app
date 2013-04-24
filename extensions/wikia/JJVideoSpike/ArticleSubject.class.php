<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 23.04.13 15:46
 *
 */

class ArticleSubject {

	protected $articleId;
	protected $articleBody;
	protected $allSubjectList;
	protected $articleTitle;

	public function __construct( $articleId, $articleBody='' ) {

		$this->articleId  = $articleId;
		if ( !empty( $articleBody ) ) {
			$this->articleBody = $articleBody;
		}
	}

	public function normalizeText( $text ) {

		$text = preg_replace( '/[^a-zA-Z0-9]/', ' ', $text );
		$text = preg_replace( '/[ ]{1,}/', ' ', $text );
		return trim ( strtolower( $text ) );
	}

	public function setAllSubjectList( $subjectList ) {
		$this->allSubjectList = $subjectList;
	}

	public function getAllSubjectList() {
		return $this->allSubjectList;
	}

	protected function fetchArticleBody() {

		$titleObject = Title::newFromID( $this->articleId );
		$article = false;

		if ( !empty( $titleObject ) && $titleObject->exists() ) {

			$article = new Article( $titleObject );
			$this->articleTitle = $titleObject->getDBKey();
		}
		else {

			throw new Exception("Couldnt load article");
		}

		if ( $article ) {
			$this->articleBody = $article->getContent();
		} else {

			throw new Exception(" Couldnt create article");
		}
	}

	public function getSubjects() {

		if ( empty( $this->articleBody ) ) {
			$this->fetchArticleBody();
		}

		$subjectList = array();

		$normalizedBody = $this->normalizeText( $this->articleBody );

		$articleLinks = array();
		preg_match_all( '/\[\[.*?(\]\]|\|)/', $this->articleBody, $articleLinks );


		foreach ( $articleLinks[0] as $i => $link ) {
			$articleLinks[0][$i] = $this->normalizeText( $link );
		}

		$articleLinks = $articleLinks[0];

		foreach ( $this->allSubjectList as $subject ) {

			$normalizedSubject = $this->normalizeText( $subject[0] );
			if ( strpos( $normalizedBody, $normalizedSubject ) !== false ) {
				$subjectList['body'][] = $subject;
			}
			if ( $normalizedSubject == $this->normalizeText( $this->articleTitle ) ) {
				$subjectList['title'][] = $subject;
			}

			foreach ( $articleLinks as $link ) {
				if ( $normalizedSubject == $link ) {
					$subjectList['links'] = $subject;
				}
			}
		}

		return $subjectList;
	}



}