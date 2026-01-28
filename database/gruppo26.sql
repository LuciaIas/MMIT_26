CREATE USER www WITH PASSWORD 'www';
CREATE DATABASE gruppo26 OWNER www;

CREATE TABLE visite_sito (
    id SERIAL PRIMARY KEY,
    data_visita TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE utenti (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password TEXT NOT NULL,
    tipo_utente VARCHAR(20) DEFAULT 'studente',
    sesso CHAR(1),
    universita VARCHAR(100)
);

CREATE TABLE quiz (
    id SERIAL PRIMARY KEY,
    titolo VARCHAR(100) NOT NULL,
    descrizione TEXT,
    tipo VARCHAR(20)
);

CREATE TABLE domande_vero_falso (
    id SERIAL PRIMARY KEY,
    id_quiz INT NOT NULL REFERENCES quiz(id) ON DELETE CASCADE,
    testo TEXT NOT NULL,
    risposta_corretta BOOLEAN NOT NULL
);

CREATE TABLE domande_completa_frase (
    id SERIAL PRIMARY KEY,
    id_quiz INT NOT NULL REFERENCES quiz(id) ON DELETE CASCADE,
    frase TEXT NOT NULL,
    risposta_corretta VARCHAR(255) NOT NULL
);

CREATE TABLE domande_output_immagine (
    id SERIAL PRIMARY KEY,
    id_quiz INT NOT NULL,
    immagine VARCHAR(255) NOT NULL, 
    risposta_corretta TEXT NOT NULL      
);

CREATE TABLE domande_drag_drop (
    id SERIAL PRIMARY KEY,
    id_quiz INT NOT NULL REFERENCES quiz(id) ON DELETE CASCADE,
    termine VARCHAR(50) NOT NULL,
    definizione_corretta VARCHAR(255) NOT NULL
);

CREATE TABLE glossario (
    id SERIAL PRIMARY KEY,
    termine VARCHAR(50) NOT NULL,
    definizione TEXT NOT NULL
);

CREATE TABLE risultati_quiz (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) REFERENCES utenti(username) ON DELETE CASCADE,
    id_quiz INT REFERENCES quiz(id) ON DELETE CASCADE,
    punteggio INT,
);


INSERT INTO utenti (username, email, password, tipo_utente, sesso, universita)
VALUES (
  'Lucia Monetta',
  'l.monetta8@studenti.unisa.it',
'$2y$10$ukX63zjkwwUd15nKnFj50OrZ9u6AANTiF4vyixaeCIcF3jf3iwpPK',
  'studente',
  'F',
  'Università degli Studi di Salerno'
);
INSERT INTO utenti (username, email, password, tipo_utente, sesso, universita)
VALUES (
  'Lucia Iasevoli',
  'l.iasevoli1@studenti.unisa.it',
  '$2y$10$7GFMlhL/QKnRkyXN3XI2Ou8zk6K5kkyeoMnef18bGp3HHy2TlUA8S',
  'studente',
  'F',
  'Università degli Studi di Salerno'
);
INSERT INTO utenti (username, email, password, tipo_utente, sesso, universita)
VALUES (
  'Matteo Muccio',
  'm.muccio3@studenti.unisa.it',
  '$2y$10$V.KAJs.AqN6BU5/cA2ybXewFZJiS1CsEDSDxmGyEjHOs6pE.rZ1/W',
  'studente',
  'M',
  'Università degli Studi di Salerno'
);                                                                                                                      
INSERT INTO utenti (username, email, password, tipo_utente, sesso, universita)
VALUES (
  'Michele Tamburro',
  'm.tamburro@studenti.unisa.it',
  '$2y$10$M/HKCWBb8c7pbfnR8dcYAOrD8rTzZzhXFPnIb8B40PjR171X1o9lO',
  'studente',
  'M',
  'Università degli Studi di Salerno'
);


INSERT INTO quiz (titolo, descrizione, tipo) VALUES 
('Quiz Vero o Falso', 'Quiz di autovalutazione su HTML, CSS, JavaScript, PHP e Web', 'vero_falso'),
('Quiz Completa frase', 'Quiz di autovalutazione tramite completamento di alcune frasi', 'completamento'),
('Quiz seleziona output', 'Quiz di autovalutazione tramite scelta dell''output corretto', 'selezione'),
('Quiz drag & drop', 'Quiz di autovalutazione tramite drag & drop', 'drag_drop');


INSERT INTO domande_vero_falso (id_quiz, testo, risposta_corretta) VALUES
(1, 'HTML è un linguaggio di programmazione.', false),
(1, 'Il tag <div> serve a creare divisioni logiche di contenuto senza influenzare lo stile.', true),
(1, 'Il tag <span> è utilizzato principalmente per applicare stili inline su una parte di testo.', true),
(1, 'I commenti in HTML si scrivono così: <!-- commento -->.', true),
(1, 'In CSS, la proprietà color cambia il colore dello sfondo.', false),
(1, 'In JavaScript, document.getElementById(''id'') restituisce un array di elementi con quell''ID.', false),
(1, 'Il tag <a> serve a creare link ipertestuali tra pagine web.', true),
(1, 'Le proprietà CSS margin e padding hanno lo stesso effetto sul layout.', false),
(1, 'JavaScript può modificare dinamicamente il contenuto di una pagina web.', true),
(1, 'L''attributo target="_self" apre il link nella stessa scheda, mentre target="_blank" apre il link in una nuova scheda.', true),
(1, 'È obbligatorio rispettare la gerarchia dei titoli (h1, h2, h3, ...).', false),
(1, 'CSS supporta unità di misura assolute e relative.', true),
(1, 'Il margin è lo spazio tra il bordo dell''elemento e tutto ciò che lo circonda nella pagina.', true),
(1, 'La pseudoclasse :hover si applica quando un elemento è stato attivato dall''utente.', false),
(1, 'PHP è un linguaggio non tipato.', true),
(1, 'Un parametro con valore di default può venire prima dei parametri obbligatori.', false),
(1, 'HTTP è un protocollo stateful.', false),
(1, 'Nella funzione setcookie(nome, valore, expire, path, domain, secure) solo il nome è obbligatorio.', true),
(1, 'L''uso di * dopo SELECT consente di selezionare tutti gli attributi della tabella.', true),
(1, 'Non c''è relazione tra Java e JavaScript.', true),
(1, 'JavaScript non è case-sensitive.', false),
(1, 'Il DOM (Document Object Model) è una collezione di oggetti che rappresentano gli elementi nel documento HTML.', true),
(1, 'JavaScript è un linguaggio event-driven.', true),
(1, 'L''elemento <canvas> ha un metodo chiamato getContext() per ottenere il contesto di rendering.', true),
(1, 'Un wireframe deve necessariamente avere un alto livello di fedeltà.', false);

INSERT INTO domande_completa_frase (id_quiz, frase, risposta_corretta) VALUES
(2, 'Il linguaggio _ serve a creare la struttura delle pagine web.', 'HTML'),
(2, 'Il protocollo _ permette la trasmissione di pagine web.', 'HTTP'),
(2, '_ è un linguaggio lato server molto diffuso.', 'PHP'),
(2, 'Il Web 1.0 era caratterizzato da pagine _,  e con utenti lettori', 'STATICHE'),
(2, 'L''URL è un tipo di _ che indica la posizione di una risorsa su Internet.', 'URI');

INSERT INTO domande_output_immagine (id_quiz, immagine, risposta_corretta) 
VALUES (3, 'quiz_id3.jpeg', 'NO');

INSERT INTO domande_drag_drop (id_quiz, termine, definizione_corretta) VALUES
(4, 'HTML', 'Struttura delle pagine'),
(4, 'CSS', 'Stile delle pagine'),
(4, 'JavaScript', 'Interattività lato client'),
(4, 'PHP', 'Esecuzione lato server');

INSERT INTO glossario (termine, definizione) VALUES
('Client', 'Dispositivo che richiede servizi al server.'),
('Server', 'Sistema che fornisce servizi ai client.'),
('HTTP', 'Protocollo di comunicazione tra client e server.'),
('Database', 'Archivio strutturato di dati accessibile da applicazioni.'),
('HTML', 'HTML è il linguaggio standard per creare e strutturare pagine web (definisce titoli, paragrafi, elenchi, link, immagini e altri elementi). Il suo funzionamento si basa sui tag che indicano al browser come visualizzare il contenuto. HTML è fondamentale per qualsiasi sito web in quanto stabilisce la struttura (ma non lo stile estetico) della pagina.'),
('CSS', 'CSS definisce l''aspetto delle pagine web (colori, font, spaziature e layout), trasformando l''HTML in pagine leggibili ed esteticamente gradevoli separando la struttura dalla presentazione. Il CSS, inoltre, rende più semplice aggiornare lo stile e permette di adattare i contenuti a diversi dispositivi.'),
('JavaScript', 'JavaScript aggiunge interattività ai siti web: risponde alle azioni dell''utente, aggiorna contenuti senza ricaricare la pagina e crea animazioni/giochi. JavaScript quindi, eseguito dal browser, garantisce un''interazione fluida rendendo i siti attivi e coinvolgenti.'),
('PHP', 'PHP è un linguaggio lato server che fornisce HTML pronto al browser; è essenziale per i siti interattivi e applicazioni web complesse in quanto ha il compito di gestire login, registrazioni, moduli e interazioni con database. PHP, inoltre, elabora richieste e genera pagine personalizzate in base ai dati.'),
('Web 1.0', 'Prima fase del Web (anni ''90). Caratterizzato da pagine statiche, utenti lettori, ipertesti e URL.'),
('Web 2.0', 'Web dinamico e partecipativo, formato da blog, social network, wiki e video sharing.'),
('Web 3.0', 'Web semantico e AI. Fornisce servizi personalizzati con metadati, cookie e geolocalizzazione.'),
('Web 4.0', 'Basato sull''Internet of Things: oggetti intelligenti connessi, domotica e veicoli autonomi.'),
('Internet', 'Rete globale di reti di computer interconnessi che comunicano tramite protocolli standard (come TCP/IP).'),
('Web', 'Servizio che utilizza Internet per fornire pagine ipertestuali accessibili tramite browser.'),
('Ipertesto', 'Testo che contiene collegamenti ad altre risorse o documenti, permettendo una navigazione non lineare.'),
('URI', 'Identificatore generico usato per identificare una risorsa su Internet. Include URL e URN.'),
('URL', 'Tipo di URI che specifica la posizione di una risorsa e il metodo per accedervi.'),
('IRI', 'Estensione di URI che permette l''uso di caratteri internazionali non ASCII.'),
('Browser', 'Programma che consente di navigare il Web e visualizzare pagine web.'),
('Loopback', 'Meccanismo di rete che permette a un dispositivo di comunicare con sé stesso, usato per test.'),
('Indirizzo IP', 'Numero univoco che identifica un dispositivo all’interno di una rete.'),
('DNS', 'Sistema che traduce i nomi di dominio in indirizzi IP.'),
('GET', 'Metodo HTTP utilizzato per richiedere dati a un server.'),
('POST', 'Metodo HTTP utilizzato per inviare dati a un server.'),
('Wireframe', 'Rappresentazione schematica e semplificata della struttura di una pagina web o applicazione.'),
('Mockup', 'Rappresentazione grafica dettagliata di un''interfaccia che mostra l''aspetto visivo finale.'),
('HTML5', 'Versione più recente del linguaggio HTML che introduce nuovi elementi semantici, multimediali e API.'),
('DOM (Document Object Model)', 'Rappresentazione ad albero della struttura di una pagina web, che permette di accedere e modificare contenuti, elementi e attributi tramite linguaggi come JavaScript.');


GRANT ALL PRIVILEGES ON DATABASE gruppo26 TO www;
