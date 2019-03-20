<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315173632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content_lesson DROP FOREIGN KEY FK_9042045F84A0A3ED');
        $this->addSql('ALTER TABLE lessons_contents DROP FOREIGN KEY FK_AB7858C33C1CC488');
        $this->addSql('ALTER TABLE ranker DROP FOREIGN KEY FK_6A80789784A0A3ED');
        $this->addSql('ALTER TABLE content_lesson DROP FOREIGN KEY FK_9042045FCDF80196');
        $this->addSql('ALTER TABLE lessons_contents DROP FOREIGN KEY FK_AB7858C3CDF80196');
        $this->addSql('ALTER TABLE ranker DROP FOREIGN KEY FK_6A807897CDF80196');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_lesson');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lessons_contents');
        $this->addSql('DROP TABLE ranker');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE content_lesson (content_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_9042045F84A0A3ED (content_id), INDEX IDX_9042045FCDF80196 (lesson_id), PRIMARY KEY(content_id, lesson_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, teacher VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, duration VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lessons_contents (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, contenu_id INT DEFAULT NULL, rank VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_AB7858C33C1CC488 (contenu_id), INDEX IDX_AB7858C3CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ranker (id INT AUTO_INCREMENT NOT NULL, lesson_id INT NOT NULL, content_id INT NOT NULL, rank INT DEFAULT NULL, INDEX IDX_6A80789784A0A3ED (content_id), INDEX IDX_6A807897CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE content_lesson ADD CONSTRAINT FK_9042045F84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_lesson ADD CONSTRAINT FK_9042045FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessons_contents ADD CONSTRAINT FK_AB7858C33C1CC488 FOREIGN KEY (contenu_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE lessons_contents ADD CONSTRAINT FK_AB7858C3CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE ranker ADD CONSTRAINT FK_6A80789784A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE ranker ADD CONSTRAINT FK_6A807897CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
    }
}
