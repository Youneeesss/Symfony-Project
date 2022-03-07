<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228153843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE book_book_id_seq');
        $this->addSql('SELECT setval(\'book_book_id_seq\', (SELECT MAX(book_id) FROM book))');
        $this->addSql('ALTER TABLE book ALTER book_id SET DEFAULT nextval(\'book_book_id_seq\')');
        $this->addSql('CREATE SEQUENCE borrow_borrow_id_seq');
        $this->addSql('SELECT setval(\'borrow_borrow_id_seq\', (SELECT MAX(borrow_id) FROM borrow))');
        $this->addSql('ALTER TABLE borrow ALTER borrow_id SET DEFAULT nextval(\'borrow_borrow_id_seq\')');
        $this->addSql('CREATE SEQUENCE person_person_id_seq');
        $this->addSql('SELECT setval(\'person_person_id_seq\', (SELECT MAX(person_id) FROM person))');
        $this->addSql('ALTER TABLE person ALTER person_id SET DEFAULT nextval(\'person_person_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book ALTER book_id DROP DEFAULT');
        $this->addSql('ALTER TABLE borrow ALTER borrow_id DROP DEFAULT');
        $this->addSql('ALTER TABLE person ALTER person_id DROP DEFAULT');
    }
}
