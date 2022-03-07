<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228143817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE book ALTER book_id DROP DEFAULT');
        $this->addSql('ALTER TABLE borrow ALTER borrow_id DROP DEFAULT');
        $this->addSql('ALTER TABLE borrow ALTER person_id DROP NOT NULL');
        $this->addSql('ALTER TABLE borrow ALTER book_id DROP NOT NULL');
        $this->addSql('ALTER TABLE person ALTER person_id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE SEQUENCE book_book_id_seq');
        $this->addSql('SELECT setval(\'book_book_id_seq\', (SELECT MAX(book_id) FROM book))');
        $this->addSql('ALTER TABLE book ALTER book_id SET DEFAULT nextval(\'book_book_id_seq\')');
        $this->addSql('CREATE SEQUENCE borrow_borrow_id_seq');
        $this->addSql('SELECT setval(\'borrow_borrow_id_seq\', (SELECT MAX(borrow_id) FROM borrow))');
        $this->addSql('ALTER TABLE borrow ALTER borrow_id SET DEFAULT nextval(\'borrow_borrow_id_seq\')');
        $this->addSql('ALTER TABLE borrow ALTER book_id SET NOT NULL');
        $this->addSql('ALTER TABLE borrow ALTER person_id SET NOT NULL');
        $this->addSql('CREATE SEQUENCE person_person_id_seq');
        $this->addSql('SELECT setval(\'person_person_id_seq\', (SELECT MAX(person_id) FROM person))');
        $this->addSql('ALTER TABLE person ALTER person_id SET DEFAULT nextval(\'person_person_id_seq\')');
    }
}
