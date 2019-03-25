<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321183156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration VARCHAR(255) DEFAULT NULL, teacher VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_content (id INT AUTO_INCREMENT NOT NULL, lessons_id INT DEFAULT NULL, contents_id INT DEFAULT NULL, rank INT NOT NULL, INDEX IDX_BB9620EFED07355 (lessons_id), INDEX IDX_BB9620E394E8343 (contents_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620EFED07355 FOREIGN KEY (lessons_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620E394E8343 FOREIGN KEY (contents_id) REFERENCES content (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620E394E8343');
        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620EFED07355');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_content');
    }
}
